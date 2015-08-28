/**
 * Created by IErshov on 11.12.2014.
 */
var docState={data:{},changes:false,debug:true,flagReset:false};
var apicontrol={
    config:{
        get_keys:['source','sourceId']
    }
};

docState.check = function(){
    if(supports_html5_storage()){
        docState.storageStatus='OK';
    }else{
        docState.storageStatus='fail';
    }

    if(localStorage['docStateData']===undefined) {if(this.debug) console.log('data empty');}
    else {this.load();}
};

docState.save = function(){
    if(this.debug) console.log('docState.save start');
    if(this.flagReset===true)
    {
        this.flagReset=false;
        return false;
    }
    if(this.flagLock) return false;
    // Скрипт маски номера телефона вызывает событие change на поле с номером телефона
    if(docState.data.phone=="") delete docState.data.phone;
    if($.isEmptyObject(docState.data)) return false;

    if(this.debug) console.log(this.data);
    var str=JSON.stringify(this.data);
    if(this.debug) console.log(str);
    localStorage['docStateData']=str;
    this.changes=true;
    if(this.debug) console.log('docState.save done');
};

docState.load = function(){
    this.flagLock=true;
    var json=localStorage['docStateData'];
    var obj=JSON.parse(localStorage['docStateData']);
    this.data = obj;
    if(this.debug) {
        console.log('Load done');
        console.log(this.data);
    }

    // Заполнение всех полей
    var dat=this.data;
    formControl.check(this.data.interests);
    delete dat.interests;
    for(key in dat){
        formControl.set(synonym.revert[key], dat[key]);
    }

    this.flagLock=false;
};

docState.reset = function(){
    if(this.debug) console.log('Reset:');
    this.flagReset=true;
    if(this.debug) console.log(this);
    localStorage.removeItem('docStateData');
    $('input').val('');
    $("select option").prop("selected", false);
    $('input[type="checkbox"]').prop("checked", false);
    docState.changes=false;
    delete docState.data;
    docState.data={};
    if(this.debug) console.log('Reset done');
};

var testobj;

/* Custom field change listener
 --------------------------------------*/
function fieldChange(ptr){
    if(docState.debug) console.log('function fieldChange start');
    if(ptr===undefined || ptr.type=='change') ptr=this;

    var id = $(ptr).attr("id");
    var type = $(ptr).attr('type');
    var name = $(ptr).attr("name");
    var tag = $(ptr).get(0).tagName;
    var val, length;


    if(tag=='select') {
        val=$(ptr).find('option:selected').text();
    }
    else{
        val = $(ptr).val();
        length=val.length;
    }

    if(type=='tel') {
        if(docState.debug) console.log('tel: name='+name+' val='+val+' length='+length);
        if(length<9) return true;
    }

    if(type=='checkbox'){
        if(docState.debug) console.log('checkbox change event');
        var arr=[];
        $('[type=checkbox]:checked').each(function(){
            arr.push($(this).val());
        });
        if(docState.data.interests===undefined) docState.data.interests=[];
        docState.data.interests=arr;
    }else{
        var sname = synonym.map[name];
        docState.data[sname]=val;
        if(docState.debug) console.log('Saving sname: '+sname+' val:'+val);
    }

    docState.save();
}


/* api control
--------------------------------------*/
apicontrol.createObj=function(data){
    var url = "http://crm.syndev.ru/api/v1/student/census/create/";
    data= $.extend({},data,apicontrol.parseGET());
    var success = function (response){
        if(docState.debug) console.log(response);
        docState.data.id=response.id;
        docState.data.verify=response.verify;
        apicontrol.checkResponse(response);
    };

    $.ajax({
        type: "POST",
        dataType: "json",
        url: url,
        data: data,
        success: success
    });
};

apicontrol.parseGET = function(url){
    utm_keys = apicontrol.config.get_keys;
    if(!url || url == '') url = decodeURI(document.location.search);
    if(url.indexOf('?') < 0) return {};

    var GET = {},
        OTHER = [],
        params = [],
        key = [],
        split=[],
        new_url;

    split = url.split('?');
    new_url=window.location.pathname;
    url = split[1];


    if(url.indexOf('#')!=-1){
        url = url.substr(0,url.indexOf('#'));
    }
    if(url.indexOf('&') > -1){ params = url.split('&');} else {params[0] = url; }

    var r,z;
    for (r=0; r<params.length; r++){
        for (z=0; z<utm_keys.length; z++){
            if(params[r].indexOf(utm_keys[z]+'=') > -1){
                if(params[r].indexOf('=') > -1) {
                    key = params[r].split('=');
                    GET[key[0]]=key[1];
                }
            }
        }

        //
        key = params[r].split('=');
        if(utm_keys.indexOf(key[0])==-1) {
            OTHER.push(params[r]);
        }
    }
    if(OTHER.length) new_url+='?'+OTHER.join('&');
    if(window.location.hash) new_url+=window.location.hash;
    return (GET);
};


apicontrol.check=function(data){
    var url = "http://crm.syndev.ru/api/v1/student/census/check/";
    var success = function (response){
        if(docState.debug) console.log(response);
        apicontrol.checkResponse(response);
    };

    $.ajax({
        type: "POST",
        dataType: "json",
        url: url,
        data: data,
        success: success
    });
};

apicontrol.update=function(data){
    var url = "http://crm.syndev.ru/api/v1/student/census/update/";
    var success = function (response){
        if(docState.debug) console.log(response);
        apicontrol.checkResponse(response);
    };

    $.ajax({
        type: "POST",
        dataType: "json",
        url: url,
        data: data,
    }).always(success);
};

apicontrol.checkChanges=function(){
    if(docState.debug) console.log('tick');
    if(docState.changes){
        if(docState.debug) console.log('changes found');
        var result=0;
        // Отправка данных в API
        if(docState.data.id===undefined || docState.data.verify===undefined)
        {
            apicontrol.createObj(docState.data);
        }else{
            apicontrol.update(docState.data);
        }
        docState.changes=false;
        return true;
    }
    return false;
};

apicontrol.start=function(){
    if(docState.debug) console.log('apicontrol check changes start...');
    setInterval(apicontrol.checkChanges, 500);
    /**/
};

function supports_html5_storage() {
    try {
        return 'localStorage' in window && window['localStorage'] !== null;
    } catch (e) {
        return false;
    }
}

apicontrol.checkResponse=function(response) {
    if(docState.debug) {console.log('checkResponse()');}
    if(response.status=='failed') {
        if(docState.debug) console.log('Response: "failed"');
        if (response.message == 'Wrong verify') {
            if(docState.debug) console.log('Сброс формы');
            docState.reset();
        }
        if (response.message == 'No such object') {
            if(docState.debug) console.log('Создаём новый объект');
            apicontrol.createObj(docState.data);
        }
    }
};
