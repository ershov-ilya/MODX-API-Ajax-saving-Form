/* «Landerr» version 3.0.0 от 20.11.2014 */
function askApi(){
    var name = $(this).get(0).tagName;
    var id = $(this).attr("name");
    var val = $(this).val();
    console.log('changed '+ name+' field: '+id+' value:'+val);

    switch(id)
    {
        case 'surname': docState.data.secondname=val;
            break;
        case 'name': docState.data.name=val;
            break;
        case 'patronymic': docState.data.patronymic=val;
            break;
        case 'birth_day': docState.data.birth_day=val;
            break;
        case 'birth_month': docState.data.birth_month=val;
            break;
        case 'birth_year': docState.data.birth_year=val;
            break;
        case 'gender': docState.data.gender=val;
            break;
        case 'learning_team': docState.data.studgroup=val;
            break;
        case 'branch': docState.data.affiliate=val;
            break;
        case 'phone': docState.data.phone=val;
            break;
        case 'email': docState.data.email=val;
            break;
        case 'fio_mother': docState.data.mother_fullname=val;
            break;
        case 'surname': docState.data.secondname=val;
            break;
        default:
            console.log('?');
    }
    docState.save();
}

$("document").ready(function(){
    docState.check();
    apicontrol.start();
    $("form input, form select").on('change', askApi);

    // Получение и вывод системной информации
    $("form").on("submit", function(){
        var forms    = $(this);
        var land     = forms.data('land');      if(land)    forms.append('<input type="hidden" name="land" value="'+land+'">');
        var version  = forms.data('version');   if(version) forms.append('<input type="hidden" name="version" value="'+version+'">');
        var form     = forms.data('form');      if(form)    forms.append('<input type="hidden" name="form" value="'+form+'">');
        var cost     = forms.data('cost');      if(cost)    forms.append('<input type="hidden" name="cost" value="'+cost+'">');
        var partner  = forms.data('partner');   if(partner) forms.append('<input type="hidden" name="partner" value="'+partner+'">');
        var landname = forms.data('landname');  if(landname)forms.append('<input type="hidden" name="landname" value="'+landname+'">');
        var radio    = forms.data('radio');     if(radio)   forms.append('<input type="hidden" name="radio" value="'+radio+'">');
        var refer    = document.referrer;       if(refer)   forms.append('<input type="hidden" name="refer" value="'+refer+'">');
    });
    // Валидация формы
    $('form').each(function(){
        $(this).validate({
            errorElement: "label",
            rules:{
                "name": {required:true, minlength:2, maxlength:50, valname:true},
                "phone":{required:true, minlength:11, maxlength:25},
                "email":{required:true, email:true}
            },
            // Ajax отправка формы
            submitHandler: function(form){
                $(form).ajaxSubmit({
                    target: $(form),
                    success: function() {
                        Hash.add("app", "ok");
                    }
                });
                // Блокирование полей и кнопки
                $("input").attr("disabled", "disabled");
                $(form).find(':submit').attr({"disabled":"disabled", "value":"Отправка..."}).addClass("loading");
                $("[type = submit]:not(.loading)").attr("value","Отправлено");
            }
        })
    });
    /*
    // Автоматическая подстановка маски под номер телефона
    var maskList = $.masksSort($.masksLoad("http://suniversity.ru/lander/app/vendor/js/phone-codes.json"), ['#'], /[0-9]|#/, "mask");
    var maskOpts = {
        inputmask: {
            definitions: {'#': {validator: "[0-9]", cardinality: 1}},
            showMaskOnHover: false,
            autoUnmask: true
        },
        match: /[0-9]/,
        replace: '#',
        list: maskList,
        listKey: "mask",
        onMaskChange: function(maskObj, completed) {
            if (completed) {
                var hint = maskObj.name_ru;
                if (maskObj.desc_ru && maskObj.desc_ru != "") {
                    hint += " (" + maskObj.desc_ru + ")";
                }
            }
        }
    };
    $('[name=phone]').each(function(indx){$(this).inputmasks(maskOpts);});
    /**/

    // Перевод валидации на русский язык
    $.extend($.validator.messages, {
        required: "Обязательное поле",
        remote: "Пожалуйста, введите правильное значение.",
        email: "Пожалуйста, введите корректный адрес E-mail.",          
        maxlength: $.validator.format("Пожалуйста, введите не больше {0} символов."),
        minlength: $.validator.format("Пожалуйста, введите не меньше {0} символов."),
    });

    // Дополнительный метод валидации имени
    jQuery.validator.addMethod("valname", function(value, element) {
        return this.optional(element) || /^[А-Яа-яЁёA-Za-z\s]{2,50}$/.test(value);
    }, "Введите корректное имя");
    
    // Работоспособность плейсхолдера для IE 9 и ниже
    $('input[placeholder], textarea[placeholder]').placeholder();

});

