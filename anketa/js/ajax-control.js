/**
 * Created by IErshov on 11.12.2014.
 */
var docState={data:{},changes:false,debug:true};
var apicontrol={};

docState.check = function(){
    if(supports_html5_storage()){
        docState.storageStatus='OK';
    }else{
        docState.storageStatus='fail';
    }

    if(localStorage['docStateData']===undefined) {console.log('data empty');}
    else {this.load();}
};

docState.save = function(){
    if(this.debug) console.log(this.data);
    var str=JSON.stringify(this.data);
    if(this.debug) console.log(str);
    localStorage['docStateData']=str;
    if(this.debug) console.log('Save done');
    this.changes=true;
};

docState.load = function(){
    var json=localStorage['docStateData'];
    var obj=JSON.parse(localStorage['docStateData']);
    this.data = obj;
    if(this.debug) console.log('Load done');
    if(this.debug) console.log(this.data);
    // TODO: Заполнение всех полей
};

docState.reset = function(){
    localStorage.removeItem('docStateData');
    delete docState.data;
    if(this.debug) console.log('Reset done');
};

apicontrol.create=function(data){
    var url = "http://crm.syndev.ru/api/v1/student/create/";
    var success = function (response){
        console.log(response);
        docState.data.id=response.id;
        docState.data.verify=response.verify;
    };

    $.ajax({
        type: "POST",
        dataType: "json",
        url: url,
        data: data,
        success: success
    });
};

apicontrol.check=function(id){
    var url = "http://crm.syndev.ru/api/v1/student/check/";
    var success = function (response){ console.log(response); };

    $.ajax({
        type: "POST",
        dataType: "json",
        url: url,
        data: {id:id},
        success: success
    });
};

apicontrol.update=function(data){
    var url = "http://crm.syndev.ru/api/v1/student/update/";
    var success = function (response){ console.log(response); };

    $.ajax({
        type: "POST",
        dataType: "json",
        url: url,
        data: data,
        success: success
    });
};

apicontrol.checkChanges=function(){
    if(docState.changes){
        console.log('changes found');
        // Отправка данных в API
        if(docState.data.id===undefined || docState.data.verify===undefined)
        {
            apicontrol.create(docState.data);
        }else{
            apicontrol.update(docState.data);
        }
        docState.changes=false;
        return true;
    }
    return false;
};

apicontrol.start=function(){
    setInterval(this.checkChanges, 500);
    console.log('checkchanges start');
    /**/
};

function supports_html5_storage() {
    try {
        return 'localStorage' in window && window['localStorage'] !== null;
    } catch (e) {
        return false;
    }
}
