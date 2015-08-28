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
    name		    :	'name',
    surname 	    :	'secondname',
    patronymic	    :	'patronymic',
    birth_day	    :	'birth_day',
    birth_month	    :	'birth_month',
    birth_year	    :	'birth_year',
    gender	        :	'gender',
    learning_team   :	'studgroup',
    branch	        :	'affiliate',
    phone	        :	'phone',
    email	        :	'email',
    contact1_name   :  'contact1_name',
    contact1_phone  :  'contact1_phone',
    contact2_name   :  'contact2_name',
    contact2_phone  :  'contact2_phone',
    contact3_name   :  'contact3_name',
    contact3_phone  :  'contact3_phone',
    vk_id	        :	'vk_id',
    interests	    :	'interests',
    prof_experience :   'prof_experience',
    prof_plan       :   'prof_plan',
    prof_orientation:   'prof_orientation',
    prof_status     :   'prof_status',
    prof_income     :   'prof_income',
    referer         :   'referer'
};

/* Usage
Object for asign html form IDs with database fields
1) Fill the map
2) call: synonym.refresh();
3) Ask revert field name: var synonym_field = synonym.revert[field];
 */
