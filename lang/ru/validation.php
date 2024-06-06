<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Валидация языковых строк
    |--------------------------------------------------------------------------
    |
    | Следующие языковые строки содержат сообщения по умолчанию, используемые
    | классом валидатора. Некоторые из этих правил имеют несколько версий,
    | такие как правила размера. Мы стараемся сделать каждую строку максимально
    | понятной.
    |
    */

    "accepted" => ":attribute должен быть принят.",
    "accepted_if" => ":attribute должен быть принят, когда :other равен :value.",
    "active_url" => ":attribute не является допустимым URL-адресом.",
    "after" => ":attribute должен быть датой после :date.",
    "after_or_equal" => ":attribute должен быть датой после или равной :date.",
    "alpha" => ":attribute может содержать только буквы.",
    "alpha_dash" => ":attribute может содержать только буквы, цифры, тире и подчеркивания.",
    "alpha_num" => ":attribute может содержать только буквы и цифры.",
    "array" => ":attribute должен быть массивом.",
    "ascii" => ":attribute может содержать только символы ASCII.",
    "before" => ":attribute должен быть датой до :date.",
    "before_or_equal" => ":attribute должен быть датой до или равной :date.",
    "between" => [
        "array" => ":attribute должен содержать от :min до :max элементов.",
        "file" => ":attribute должен быть от :min до :max килобайт.",
        "numeric" => ":attribute должен быть от :min до :max.",
        "string" => ":attribute должен быть от :min до :max символов.",
    ],
    "boolean" => "Поле :attribute должен быть истинным или ложным.",
    "confirmed" => "Подтверждение :attribute не совпадает.",
    "current_password" => "Пароль неверен.",
    "date" => ":attribute не является допустимой датой.",
    "date_equals" => ":attribute должен быть датой, равной :date.",
    "date_format" => ":attribute не соответствует формату :format.",
    "decimal" => ":attribute должен быть десятичным числом.",
    "declined" => ":attribute должен быть отклонен.",
    "declined_if" => ":attribute должен быть отклонен, когда :other равен :value.",
    "different" => ":attribute и :other должны быть разными.",
    "digits" => ":attribute должен быть :digits цифрами.",
    "digits_between" => ":attribute должен быть от :min до :max цифрами.",
    "dimensions" => "Размеры :attribute недопустимы.",
    "distinct" => "Поле :attribute имеет повторяющееся значение.",
    "doesnt_end_with" =>
        ":attribute должен заканчиваться одним из следующих: :values.",
    "doesnt_start_with" =>
        ":attribute должен начинаться с одного из следующих: :values.",
    "email" => ":attribute должен быть действительным адресом электронной почты.",
    "ends_with" =>
        ":attribute должен заканчиваться одним из следующих: :values.",
    "enum" => ":attribute должен быть допустимым значением перечисления.",
    "exist" => "Выбранный :attribute недействителен.",
    "filled" => "Поле :attribute должно быть заполнено.",
    "gt" => [
        "array" => ":attribute должен содержать больше, чем :value элементов.",
        "file" => ":attribute должен быть больше, чем :value килобайт.",
        "numeric" => ":attribute должен быть больше, чем :value.",
        "string" => ":attribute должен быть больше, чем :value символов.",
    ],
    "gte" => [
        "array" => ":attribute должен содержать :value элементов или больше.",
        "file" =>
            ":attribute должен быть больше или равен :value килобайтам.",
        "numeric" => ":attribute должен быть больше или равен :value.",
        "string" =>
            ":attribute должен быть больше или равен :value символам.",
    ],
    "image" => ":attribute должен быть изображением.",
    "in" => "Выбранный :attribute недействителен.",
    "in_array" => "Поле :attribute не существует в :other.",
    "integer" => ":attribute должен быть целым числом.",
    "ip" => ":attribute должен быть действительным IP-адресом.",
    "ipv4" => ":attribute должен быть действительным IPv4-адресом.",
    "ipv6" => ":attribute должен быть действительным IPv6-адресом.",
    "json" => ":attribute должен быть действительной строкой JSON.",
    "lowercase" => ":attribute должен быть в нижнем регистре.",
    "lt" => [
        "array" => ":attribute должен содержать меньше, чем :value элементов.",
        "file" => ":attribute должен быть меньше, чем :value килобайт.",
        "numeric" => ":attribute должен быть меньше, чем :value.",
        "string" => ":attribute должен быть меньше, чем :value символов.",
    ],
    "lte" => [
        "array" => ":attribute должен содержать :value элементов или меньше.",
        "file" =>
            ":attribute должен быть меньше или равен :value килобайтам.",
        "numeric" => ":attribute должен быть меньше или равен :value.",
        "string" =>
            ":attribute должен быть меньше или равен :value символам.",
    ],
    "mac_address" => ":attribute должен быть действительным MAC-адресом.",
    "max" => [
        "array" => ":attribute не может содержать более :max элементов.",
        "file" => ":attribute не может быть больше, чем :max килобайт.",
        "numeric" => ":attribute не может быть больше, чем :max.",
        "string" => ":attribute не может быть больше, чем :max символов.",
    ],
    "max_digits" => ":attribute не может быть больше, чем :max цифр.",
    "mimes" => ":attribute должен быть файлом типа: :values.",
    "mimetypes" => ":attribute должен быть файлом типа: :values.",
    "min" => [
        "array" => ":attribute должен содержать не менее :min элементов.",
        "file" => ":attribute должен быть не менее :min килобайт.",
        "numeric" => ":attribute должен быть не менее :min.",
        "string" => ":attribute должен быть не менее :min символов.",
    ],
    "min_digits" => ":attribute должен быть не менее :min цифр.",
    "multiple_of" => ":attribute должен быть кратным :value.",
    "not_in" => "Выбранный :attribute недействителен.",
    "not_regex" => "Формат :attribute недействителен.",
    "numeric" => ":attribute должен быть числом.",
    "password" => [
        "letters" => ":attribute должен содержать по крайней мере одну букву.",
        "mixed" =>
            ":attribute должен содержать по крайней мере одну букву и одну цифру.",
        "numbers" => ":attribute должен содержать по крайней мере одну цифру.",
        "symbols" => ":attribute должен содержать по крайней мере один символ.",
        "uncompromised" =>
            ":attribute был взломан и не может быть использован. Пожалуйста, выберите другой.",
    ],
    "present" => "Поле :attribute должно присутствовать.",
    "prohibited" => "Поле :attribute запрещено.",
    "prohibited_if" =>
        "Поле :attribute запрещено, если :other равно :value.",
    "prohibited_unless" =>
        "Поле :attribute запрещено, если :other не находится в :values.",
    "prohibits" => "Поле :attribute запрещает присутствие :other.",
    "regex" => "Формат :attribute недопустим.",
    "required" => "Поле :attribute обязательно.",
    "required_array_keys" =>
        "Поле :attribute должно содержать записи для: :значений.",
    "required_if" => "Поле :attribute обязательно, когда :other - это :значение.",
    "required_if_accepted" =>
        "Поле :attribute обязательно, когда принимается :other.",
    "required_unless" =>
        "Поле :attribute обязательно, если :other не находится в :values.",
    "required_with" =>
        "Поле :attribute обязательно, когда присутствует :values.",
    "required_with_all" =>
        "Поле :атрибут обязательно, когда присутствуют :значения.",
    "required_without" =>
        "Поле :attribute обязательно, когда :values отсутствует.",
    "required_without_all" =>
        "Поле :attribute обязательно, когда ни одно из :values не присутствует.",
    "same" => "Поле :attribute и :other должны совпадать.",
    "size" => [
        "array" => ":attribute должен содержать :size элементов.",
        "file" => ":attribute должен быть :size килобайт.",
        "numeric" => ":attribute должен быть :size.",
        "string" => ":attribute должен быть :size символов.",
    ],
    "starts_with" =>
        "Поле :attribute должно начинаться с одного из следующих: :values.",
    "string" => "Поле :attribute должно быть строкой.",
    "timezone пояс" => "Поле :attribute должно быть допустимой зоной.",
    "unique" => "Такое значение поля :attribute уже существует.",
    "uploaded" => "Не удалось загрузить :attribute.",
    "uppercase регистр" => "Поле :attribute должно быть в верхнем регистре.",
    "url" => "Формат :attribute недопустим.",
    "ulid" => ":attribute должен быть допустимым ULID.",
    "uuid" => ":attribute должен быть допустимым UUID.",

    /*
    |--------------------------------------------------------------------------
    | Пользовательские сообщения об ошибках
    |--------------------------------------------------------------------------
    |
    | Следующие языковые строки используются для замены меток атрибута
    | с чем-то более дружественным для чтения, таким как «Адрес электронной почты» вместо
    | «электронная почта». Это просто помогает нам сделать наше сообщение более выразительным.
    |
    */

    "custom" => [
        "attribute-name" => [
            "rule-name" => "custom-message",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Пользовательские атрибуты
    |--------------------------------------------------------------------------
    |
    | Следующие языковые строки используются для замены меток атрибута.
    | Это позволяет нам указать более дружественное имя атрибута для каждого правила,
    | которое используется в приложении.
    |
    */

    "attributes" => [],
];
