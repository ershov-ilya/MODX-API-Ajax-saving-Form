/**
 * Created by IErshov on 12.12.2014.
 */

var synonym={size:0, revert:{}};
synonym.refresh = function(){
    this.revert={};
    this.size=0;
    for(var key in this.map) {
        // key - название свойства
        // object[key] - значение свойства
        this.revert[this.map[key]]=key;
        this.size++;
    }
    return true;
};

synonym.map ={
    surname 	:	'secondname',
    name		:	'name',
    patronymic	:	'patronymic',
    birth_day	:	'birth_day',
    birth_month	:	'birth_month',
    birth_year	:	'birth_year',
    gender	    :	'gender',
    learning_team:	'studgroup',
    branch	    :	'affiliate',
    phone	    :	'phone',
    email	    :	'email',
    fio_mother	:	'mother_fullname',
    mother_phone:	'mother_phone',
    fio_father	:	'father_fullname',
    father_phone:	'father_phone',
    vk_id	    :	'vkcomID',
    interests	:	'interests'
};

/* Usage
Object for asign html form IDs with database fields
1) Fill the map
2) call: synonym.refresh();
3) Ask revert field name: var synonym_field = synonym.revert[field];
 */

synonym.set=function(name, value) {
    var scenarios = ['input-text', 'input-radio', 'select', 'input-checkbox'];
    var scenario = '';
    var found = false;

    var ptr = $('#' + name + '');
    if (ptr && ptr.size()) found = true;

    if (!found) {
        ptr = $('[name=' + name + ']');
        if (ptr && ptr.size()) found = true;
    }

    if(found){
        var select=/select/i;
        var input=/input/i;
        var radio=/radio/i;
        var checkbox=/checkbox/i;
        var text=/text/i;

        var tag = $(ptr).get(0).tagName;
        var type = $(ptr).attr('type');
        if(select.test(tag)){
            scenario='select';
        }else if(input.test(tag)){
            scenario='input';
            if(radio.test(type)){
                scenario='input-radio';
            }else if(checkbox.test(type)) {
                scenario='input-checkbox';
            }else if(type===undefined || text.test(type)){
                scenario='input-text';
            }
        }

        switch(scenario){
            case 'input-text':
                ptr.val(value);
                return true;
            break;
            case 'input-radio':
                var ptr=$('[name="'+name+'"]').prop("checked", false);
                ptr.each(function(){
                    if($(this).val()==value) $(this).prop("checked", true);
                });
                return true;
            break;
            case 'select':
                ptr.find("option").prop("selected", false);
                ptr.find('[value="'+value+'"]').prop("selected", true);
                console.log('select');
                return true;
            break;
            case 'input-checkbox':
                console.log('input-checkbox');
                return true;
            break;
            default:
                console.log('Bad scenario: '+scenario);
        }
    }
    return false;
};