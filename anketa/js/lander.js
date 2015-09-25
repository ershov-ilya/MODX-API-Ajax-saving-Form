/* «Landerr» version 3.0.0 от 20.11.2014 */
$("document").ready(function(){
    formControl.listen();
    if($('body').hasClass('autocomplete')) {
        $("#autocomplete-group").autocomplete({
            source: groups_source,
            minLength: 2,
            change:function(){$(this).trigger('change');}
        });
        $("#autocomplete-group").on('change', function(){
            var val=$(this).val();
            var found=false;
            for(key in groups_source){
                if(val==groups_source[key]){
                    found=true;
                    break;
                }
            }
            if(!found) {$(this).val('');}
            return false;
        });
    }

    synonym.refresh();
    docState.check();
    $("form input, form select").on('change', fieldChange);
    setTimeout(apicontrol.start,2000);

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
                        if(Hash) Hash.add("app", "ok");
                    }
                });
                // Блокирование полей и кнопки
                $("input").attr("disabled", "disabled");
                $(form).find(':submit').attr({"disabled":"disabled", "value":"Отправка..."}).addClass("loading");
                $("[type = submit]:not(.loading)").attr("value","Отправлено");
            }
        })
    });

    // Автоматическая подстановка маски под номер телефона
    var maskList = $.masksSort($.masksLoad("js/phone-codes.json"), ['#'], /[0-9]|#/, "mask");
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

            /*docState.data.phone=$('[name=phone]').val();
            docState.save();*/
            fieldChange(this);
            /*
            console.log('phone field ');
            console.log($(this));
            */
        }
    };
    $('input[type="tel"]').each(function(indx){$(this).inputmasks(maskOpts);});
    /**/

    // Перевод валидации на русский язык
    $.extend($.validator.messages, {
        required: "Обязательное поле",
        remote: "Пожалуйста, введите правильное значение.",
        email: "Пожалуйста, введите корректный адрес E-mail.",          
        maxlength: $.validator.format("Пожалуйста, введите не больше {0} символов."),
        minlength: $.validator.format("Пожалуйста, введите не меньше {0} символов.")
    });

    // Дополнительный метод валидации имени
    jQuery.validator.addMethod("valname", function(value, element) {
        return this.optional(element) || /^[А-Яа-яЁёA-Za-z\s]{2,50}$/.test(value);
    }, "Введите корректное имя");
    
    // Работоспособность плейсхолдера для IE 9 и ниже
    $('input[placeholder], textarea[placeholder]').placeholder();

});

