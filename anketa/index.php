<!DOCTYPE HTML>
<html>
<head>
    <title>Synergy Quest</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="img/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <link href="css/template.css" rel="stylesheet" type="text/css"/>
    <link href="css/modules.css" rel="stylesheet" type="text/css"/>
    <link href="css/typography.css" rel="stylesheet" type="text/css"/>
    <link href="css/jquery-ui.css" rel="stylesheet" />
</head>
<body class="jquery-ui autocomplete">
<div id="container">
    <div id="section1" class="section">
    <form action="contacts.htm" method="POST" class="application">
    	<div class="block bg1">
        	<div class="in-block navi1">
                <p><span>*</span> Поля обязательные для заполнения</p>
                <div>
                	<div class="label">Фамилия <span>*</span></div>
                    <input type="text" name="surname" id="secondname" required>
                </div>
                <div>
                    <div class="label">Имя <span>*</span></div>
                    <input type="text" name="name" id="name" required>
                </div>
                <div>
                    <div class="label">Отчество <span>*</span></div>
                    <input type="text" name="patronymic" id="patronymic" required>
                </div>
                <div>
                    <div class="label label2">Дата рождения <span>*</span></div>
                    <select name="birth_day" id="birth_day" required>
                    	<option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                    </select>
                    <select name="birth_month" id="birth_month" required>
                    	<option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    <select name="birth_year" id="birth_year" required>
                        <option value="1970">1970</option>
                        <option value="1971">1971</option>
                        <option value="1972">1972</option>
                        <option value="1973">1973</option>
                        <option value="1974">1974</option>
                        <option value="1975">1975</option>
                        <option value="1976">1976</option>
                        <option value="1977">1977</option>
                        <option value="1978">1978</option>
                        <option value="1979">1979</option>
                        <option value="1980">1980</option>
                        <option value="1981">1981</option>
                        <option value="1982">1982</option>
                        <option value="1983">1983</option>
                        <option value="1984">1984</option>
                        <option value="1985">1985</option>
                        <option value="1986">1986</option>
                        <option value="1987">1987</option>
                        <option value="1988">1988</option>
                        <option value="1989">1989</option>
                        <option value="1990">1990</option>
                        <option value="1991">1991</option>
                        <option value="1992">1992</option>
                        <option value="1993">1993</option>
                        <option value="1994">1994</option>
                        <option value="1995">1995</option>
                        <option value="1996">1996</option>
                        <option value="1997">1997</option>
                        <option value="1998">1998</option>
                        <option value="1999">1999</option>
                        <option value="2000">2000</option>
                        <option value="2001">2001</option>
                        <option value="2002">2002</option>
                        <option value="2003">2003</option> 
                    </select>
                </div>
                <div>
                    <div class="label">Пол</div>
                    	<div>
                            <input type="radio" value="1" name="gender" id="male" required><label for="male">мужской</label>
                            <input type="radio" value="2" name="gender" id="female" required><label for="female">женский</label>
                    	</div>
                </div>
                <div>
                    <div class="label">Тел. моб. <span>*</span></div>
                    <input type="tel" name="phone" placeholder="+7 (915) 123-45-67" required>
                </div>
                <div>
                    <div class="label">E-mail <span>*</span></div>
                    <input type="email" name="email" placeholder="your_name@mail.ru" required>
                </div>
                <div>
                    <div class="label label2">Учебная группа</div>
                    <input id="autocomplete-group" type="text" name="learning_team" required>
                </div>
                <div>
                    <div class="label">Филиал</div>
                    <select name="branch" required>
                    <option value=""></option>
                        <option value="Москва">Москва</option>
<optgroup label="Филиалы">
    <option value="Карачаево-Черкесский">Карачаево-Черкесский</option>
    <option value="Калмыцкий">Калмыцкий</option>
    <option value="Ноябрьский">Ноябрьский</option>
    <option value="Краснознаменский">Краснознаменский</option>
    <option value="Астраханский">Астраханский</option>
    <option value="Омский">Омский</option>
    <option value="Подольский">Подольский</option>
    <option value="Волгодонский">Волгодонский</option>
    <option value="Тамбовский">Тамбовский</option>
    <option value="Марийский">Марийский</option>
    <option value="Благовещенский (МосАп)">Благовещенский (МосАп)</option>
    <option value="Барнаульский (МосАп)">Барнаульский (МосАп)</option>
    <option value="Ярославский (МосАп)">Ярославский (МосАп)</option>
    <option value="Горячеключевский (МосАп)">Горячеключевский (МосАп)</option>
    <option value="Пермский (МосАп)">Пермский (МосАп)</option>
    <option value="Ростовский-на-Дону (МосАп)">Ростовский-на-Дону (МосАп)</option>
    <option value="Тульский (МосАп)">Тульский (МосАп)</option>
    <option value="Сургутский (МосАп)">Сургутский (МосАп)</option>
    <option value="Казанский (МосАп)">Казанский (МосАп)</option>
    <option value="Мурманский (МосАп)">Мурманский (МосАп)</option>
</optgroup>
<optgroup label="Представительства">
    <option value="Крым">Крым</option>
    <option value="Бузулук (Приволжский филиал)">Бузулук (Приволжский филиал)</option>
    <option value="Королев">Королев</option>
    <option value="Красногорск">Красногорск</option>
    <option value="Кострома">Кострома</option>
    <option value="Бронницы">Бронницы</option>
    <option value="Долгопрудный">Долгопрудный</option>
    <option value="Нальчик">Нальчик</option>
    <option value="Санкт-Петербург">Санкт-Петербург</option>
    <option value="Новый Уренгой">Новый Уренгой</option>
    <option value="Обнинск">Обнинск</option>
    <option value="Саратов">Саратов</option>
    <option value="Ставрополь">Ставрополь</option>
    <option value="Уфа">Уфа</option>
    <option value="Латвия">Латвия</option>
    <option value="Владивосток">Владивосток</option>
    <option value="Екатеринбург">Екатеринбург</option>
    <option value="Казань">Казань</option>
    <option value="Красноярск">Красноярск</option>
    <option value="Литва">Литва</option>
    <option value="Нижний Новгород">Нижний Новгород</option>
    <option value="Сургут">Сургут</option>
    <option value="Эстония">Эстония</option>
    <option value="Ростов-на-Дону">Ростов-на-Дону</option>
</optgroup>
<optgroup label="Партнеры">
    <option value="Алматы/Астана, Казахстан">Алматы/Астана, Казахстан</option>
    <option value="Самара">Самара</option>
    <option value="Пермь">Пермь</option>
    <option value="Рыбинск">Рыбинск</option>
    <option value="Челябинск">Челябинск</option>
    <option value="Магнитогорск">Магнитогорск</option>
    <option value="Атырау, Казахстан">Атырау, Казахстан</option>
    <option value="Тбилиси">Тбилиси</option>
    <option value="Санкт-Петербург (2)">Санкт-Петербург (2)</option>
    <option value="Тольятти">Тольятти</option>
    <option value="Дмитров/Сергиев Посад">Дмитров/Сергиев Посад</option>
    <option value="Санкт-Петербург (1)">Санкт-Петербург (1)</option>
    <option value="Рязань">Рязань</option>
    <option value="Набережные Челны">Набережные Челны</option>
    <option value="Владикавказ">Владикавказ</option>
    <option value="Железнодорожный">Железнодорожный</option>
    <option value="Лысьва">Лысьва</option>
    <option value="Новосибирск">Новосибирск</option>
    <option value="Чебоксары">Чебоксары</option>
    <option value="Щелково">Щелково</option>
</optgroup>
<optgroup label="Консолидация">
    <option value="Казахстан">Казахстан</option>
    <option value="Орловская область (РФ)">Орловская область (РФ)</option>
    <option value="Беларусь">Беларусь</option>
    <option value="Сахалинская область (РФ)">Сахалинская область (РФ)</option>
    <option value="Молдова">Молдова</option>
    <option value="Иркутская область (РФ)">Иркутская область (РФ)</option>
    <option value="Таджикистан">Таджикистан</option>
    <option value="Узбекистан">Узбекистан</option>
    <option value="Республика Коми (РФ)">Республика Коми (РФ)</option>
    <option value="Армения">Армения</option>
</optgroup>
</select>
</div>
                <div>
                	<div class="label"></div>
                    <a href="contacts.htm" class="next">Далее &gt;</a>
                </div>
        	</div>
        </div>
        </form>
    </div>
</div>
    <script src="js/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="js/groups.js" type="text/javascript"></script>

    <script type="text/javascript" src="js/jquery.form-placeholder.min.js"></script>
    <script type="text/javascript" src="js/jquery.inputmask-multi-bind.js"></script> 
    <script type="text/javascript" src="js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="js/synonym.config.js"></script>
    <script type="text/javascript" src="assets/parse-get/parse-get.min.js"></script>
    <script type="text/javascript" src="js/js-cookie/src/js.cookie.js"></script>
    <script type="text/javascript" src="js/form-control.js"></script>
    <script type="text/javascript" src="js/ajax-control.js"></script>
    <script type="text/javascript" src="js/lander.js"></script>
    <script type="text/javascript">
        var ref="<?=$_SERVER['HTTP_REFERER'];?>";
        if(ref) docState.data.http_referer=ref;
    </script>
<!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/files/css3-mediaqueries.js"></script>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</body>
</html>