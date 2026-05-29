<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'nic_required' => 'ජනතා නිලධාරී හැඳුනුම් අංකය අවශ්‍යයි!',
    'nic_unique' => 'ජාතික හැඳුනුම්පත් අංකය තිබුණා!',
    'accepted' => ':attribute ක්ෂේත්‍රය පිළිගත යුතුය.',
    'accepted_if' => ':attribute ක්ෂේත්‍රය :other :value වන විට පිළිගත යුතුය.',
    'active_url' => ':attribute ක්ෂේත්‍රය වලංගු URL එකක් විය යුතුය.',
    'after' => ':attribute ක්ෂේත්‍රය :date පසු දිනයක් විය යුතුය.',
    'after_or_equal' => ':attribute ක්ෂේත්‍රය :date පසු හෝ සමාන දිනයක් විය යුතුය.',
    'alpha' => ':attribute ක්ෂේත්‍රය අකුරු පමණක් අඩංගු විය යුතුය.',
    'alpha_dash' => ':attribute ක්ෂේත්‍රය අකුරු, සංඛ්‍යා, කෙටිගහනයන්, සහ ඉහළපැන්ඩුවන් පමණක් අඩංගු විය යුතුය.',
    'alpha_num' => ':attribute ක්ෂේත්‍රය අකුරු සහ සංඛ්‍යා පමණක් අඩංගු විය යුතුය.',
    'array' => ':attribute ක්ෂේත්‍රය අරාක්කයක් විය යුතුය.',
    'ascii' => ':attribute ක්ෂේත්‍රය ඒකබායිට් අකුරු සහ සංකේත පමණක් අඩංගු විය යුතුය.',
    'before' => ':attribute ක්ෂේත්‍රය :date පෙර දිනයක් විය යුතුය.',
    'before_or_equal' => ':attribute ක්ෂේත්‍රය :date පෙර හෝ සමාන දිනයක් විය යුතුය.',
    'between' => [
        'array' => ':attribute ක්ෂේත්‍රය :min සහ :max අයිතම අතර විය යුතුය.',
        'file' => ':attribute ක්ෂේත්‍රය :min සහ :max කිලෝබයිට් අතර විය යුතුය.',
        'numeric' => ':attribute ක්ෂේත්‍රය :min සහ :max අතර විය යුතුය.',
        'string' => ':attribute ක්ෂේත්‍රය :min සහ :max අකුරු අතර විය යුතුය.',
    ],
    'boolean' => ':attribute ක්ෂේත්‍රය සත්‍ය හෝ අසත්‍ය විය යුතුය.',
    'can' => ':attribute ක්ෂේත්‍රය අවසර නොලත් අගයක් අඩංගු කර ඇත.',
    'confirmed' => ':attribute ක්ෂේත්‍රය තහවුරු කිරීම ගැලපෙන්නේ නැත.',
    'current_password' => 'මුරපදය වැරදි වී ඇත.',
    'date' => ':attribute ක්ෂේත්‍රය වලංගු දිනයක් විය යුතුය.',
    'date_equals' => ':attribute ක්ෂේත්‍රය :date සමඟ සමාන දිනයක් විය යුතුය.',
    'date_format' => ':attribute ක්ෂේත්‍රය :format ආකෘතිය සමඟ ගැලපේන නැත.',
    'decimal' => ':attribute ක්ෂේත්‍රය :decimal දශම ස්ථාන තිබිය යුතුය.',
    'declined' => ':attribute ක්ෂේත්‍රය ප්‍රතික්ෂේප කළ යුතුය.',
    'declined_if' => ':attribute ක්ෂේත්‍රය :other :value වන විට ප්‍රතික්ෂේප කළ යුතුය.',
    'different' => ':attribute ක්ෂේත්‍රය සහ :other වෙනස් විය යුතුය.',
    'digits' => ':attribute ක්ෂේත්‍රය :digits ඉලක්කම් විය යුතුය.',
    'digits_between' => ':attribute ක්ෂේත්‍රය :min සහ :max ඉලක්කම් අතර විය යුතුය.',
    'dimensions' => ':attribute ක්ෂේත්‍රය වලංගු නොවන රූප මානයන් ඇත.',
    'distinct' => ':attribute ක්ෂේත්‍රය සමාන අගයක් ඇත.',
    'doesnt_end_with' => ':attribute ක්ෂේත්‍රය :values වලින් කිසිවක් අවසන් නොවිය යුතුය.',
    'doesnt_start_with' => ':attribute ක්ෂේත්‍රය :values වලින් කිසිවක් ආරම්භ නොවිය යුතුය.',
    'email' => ':attribute ක්ෂේත්‍රය වලංගු විද්‍යුත් තැපැල් ලිපිනයක් විය යුතුය.',
    'ends_with' => ':attribute ක්ෂේත්‍රය :values වලින් එකක් සමඟ අවසන් විය යුතුය.',
    'enum' => 'තෝරාගත් :attribute වලංගු නැත.',
    'exists' => 'තෝරාගත් :attribute වලංගු නැත.',
    'extensions' => ':attribute ක්ෂේත්‍රය :values ප්‍රතිදාන වලින් එකක් තිබිය යුතුය.',
    'file' => ':attribute ක්ෂේත්‍රය ගොනුවක් විය යුතුය.',
    'filled' => ':attribute ක්ෂේත්‍රයට අගයක් තිබිය යුතුය.',
    'gt' => [
        'array' => ':attribute ක්ෂේත්‍රය :value අයිතම පනී.',
        'file' => ':attribute ක්ෂේත්‍රය :value කිලෝබයිට් ඉක්මවිය යුතුය.',
        'numeric' => ':attribute ක්ෂේත්‍රය :value ට වඩා වැඩි විය යුතුය.',
        'string' => ':attribute ක්ෂේත්‍රය :value අකුරු ට වඩා වැඩි විය යුතුය.',
    ],
    'gte' => [
        'array' => ':attribute ක්ෂේත්‍රය :value අයිතම හෝ වැඩි දේවල් තිබිය යුතුය.',
        'file' => ':attribute ක්ෂේත්‍රය :value කිලෝබයිට් හෝ වැඩි විය යුතුය.',
        'numeric' => ':attribute ක්ෂේත්‍රය :value හෝ වැඩි විය යුතුය.',
        'string' => ':attribute ක්ෂේත්‍රය :value අකුරු හෝ වැඩි විය යුතුය.',
    ],
    'hex_color' => ':attribute ක්ෂේත්‍රය වලංගු හෙක්සපද ප්‍රමාණයක් විය යුතුය.',
    'image' => ':attribute ක්ෂේත්‍රය රූපයක් විය යුතුය.',
    'in' => 'තෝරාගත් :attribute වලංගු නැත.',
    'in_array' => ':attribute ක්ෂේත්‍රය :other තුළ තිබිය යුතුය.',
    'integer' => ':attribute ක්ෂේත්‍රය පූර්ණ සංඛ්‍යා විය යුතුය.',
    'ip' => ':attribute ක්ෂේත්‍රය වලංගු IP ලිපිනයක් විය යුතුය.',
    'ipv4' => ':attribute ක්ෂේත්‍රය වලංගු IPv4 ලිපිනයක් විය යුතුය.',
    'ipv6' => ':attribute ක්ෂේත්‍රය වලංගු IPv6 ලිපිනයක් විය යුතුය.',
    'json' => ':attribute ක්ෂේත්‍රය වලංගු JSON ගේනක් විය යුතුය.',
    'lowercase' => ':attribute ක්ෂේත්‍රය පොඩි අකුරු අඩංගු විය යුතුය.',
    'lt' => [
        'array' => ':attribute ක්ෂේත්‍රය :value අයිතම ට වඩා අඩු විය යුතුය.',
        'file' => ':attribute ක්ෂේත්‍රය :value කිලෝබයිට් ට වඩා අඩු විය යුතුය.',
        'numeric' => ':attribute ක්ෂේත්‍රය :value ට වඩා අඩු විය යුතුය.',
        'string' => ':attribute ක්ෂේත්‍රය :value අකුරු ට වඩා අඩු විය යුතුය.',
    ],
    'lte' => [
        'array' => ':attribute ක්ෂේත්‍රයට :value අයිතම ට වැඩි විය නොහැක.',
        'file' => ':attribute ක්ෂේත්‍රය :value කිලෝබයිට් ට වඩා අඩු හෝ සමාන විය යුතුය.',
        'numeric' => ':attribute ක්ෂේත්‍රය :value ට වඩා අඩු හෝ සමාන විය යුතුය.',
        'string' => ':attribute ක්ෂේත්‍රය :value අකුරු ට වඩා අඩු හෝ සමාන විය යුතුය.',
    ],
    'mac_address' => ':attribute ක්ෂේත්‍රය වලංගු MAC ලිපිනයක් විය යුතුය.',
    'max' => [
        'array' => ':attribute ක්ෂේත්‍රයට :max අයිතම ට වඩා අඩු විය නොහැක.',
        'file' => ':attribute ක්ෂේත්‍රය :max කිලෝබයිට් ට වඩා අඩු විය නොහැක.',
        'numeric' => ':attribute ක්ෂේත්‍රය :max ට වඩා අඩු විය නොහැක.',
        'string' => ':attribute ක්ෂේත්‍රය :max අකුරු ට වඩා අඩු විය නොහැක.',
    ],
    'max_digits' => ':attribute ක්ෂේත්‍රය :max ඉලක්කම් ට වඩා අඩු විය නොහැක.',
    'mimes' => ':attribute ක්ෂේත්‍රය :values වර්ගයේ ගොනුවක් විය යුතුය.',
    'mimetypes' => ':attribute ක්ෂේත්‍රය :values වර්ගයේ ගොනුවක් විය යුතුය.',
    'min' => [
        'array' => ':attribute ක්ෂේත්‍රයට අවම වශයෙන් :min අයිතම තිබිය යුතුය.',
        'file' => ':attribute ක්ෂේත්‍රය අවම වශයෙන් :min කිලෝබයිට් තිබිය යුතුය.',
        'numeric' => ':attribute ක්ෂේත්‍රය අවම වශයෙන් :min විය යුතුය.',
        'string' => ':attribute ක්ෂේත්‍රය අවම වශයෙන් :min අකුරු තිබිය යුතුය.',
    ],
    'min_digits' => ':attribute ක්ෂේත්‍රය අවම වශයෙන් :min ඉලක්කම් තිබිය යුතුය.',
    'missing' => ':attribute ක්ෂේත්‍රය අස්ථානගත විය යුතුය.',
    'missing_if' => ':attribute ක්ෂේත්‍රය :other :value වන විට අස්ථානගත විය යුතුය.',
    'missing_unless' => ':attribute ක්ෂේත්‍රය :other :value නොවන විට අස්ථානගත විය යුතුය.',
    'missing_with' => ':attribute ක්ෂේත්‍රය :values පවතින විට අස්ථානගත විය යුතුය.',
    'missing_with_all' => ':attribute ක්ෂේත්‍රය :values පවතින විට අස්ථානගත විය යුතුය.',
    'multiple_of' => ':attribute ක්ෂේත්‍රය :value ගුණාංගයක් විය යුතුය.',
    'not_in' => 'තෝරාගත් :attribute වලංගු නැත.',
    'not_regex' => ':attribute ක්ෂේත්‍රය ආකෘතිය වලංගු නැත.',
    'numeric' => ':attribute ක්ෂේත්‍රය සංඛ්‍යා විය යුතුය.',
    'password' => [
        'letters' => ':attribute ක්ෂේත්‍රයට අවම වශයෙන් එක් අකුරක් තිබිය යුතුය.',
        'mixed' => ':attribute ක්ෂේත්‍රයට අවම වශයෙන් එක් පොඩි අකුරක් සහ එක් විශාල අකුරක් තිබිය යුතුය.',
        'numbers' => ':attribute ක්ෂේත්‍රයට අවම වශයෙන් එක් සංඛ්‍යාවක් තිබිය යුතුය.',
        'symbols' => ':attribute ක්ෂේත්‍රයට අවම වශයෙන් එක් සංකේතයක් තිබිය යුතුය.',
        'uncompromised' => 'නීතිවිරෝධී දත්ත හෝ ප්‍රස්ථාරයක :attribute පවතින බැවින් වෙනස් කරන්න.',
    ],
    'present' => ':attribute ක්ෂේත්‍රය පවතින්නෙය.',
    'present_if' => ':attribute ක්ෂේත්‍රය :other :value වන විට පවතින්නෙය.',
    'present_unless' => ':attribute ක්ෂේත්‍රය :other :value නොවන විට පවතින්නෙය.',
    'present_with' => ':attribute ක්ෂේත්‍රය :values පවතින විට පවතින්නෙය.',
    'present_with_all' => ':attribute ක්ෂේත්‍රය :values පවතින විට පවතින්නෙය.',
    'prohibited' => ':attribute ක්ෂේත්‍රය තහනම් වේ.',
    'prohibited_if' => ':attribute ක්ෂේත්‍රය :other :value වන විට තහනම් වේ.',
    'prohibited_unless' => ':attribute ක්ෂේත්‍රය :other :values තුළ නොමැති නම් තහනම් වේ.',
    'prohibits' => ':attribute ක්ෂේත්‍රය :other පවතින්නේ වැලක්වයි.',
    'regex' => ':attribute ක්ෂේත්‍රය ආකෘතිය වලංගු නැත.',
    'required' => ':attribute ක්ෂේත්‍රය අවශ්‍යයි.',
    'required_array_keys' => ':attribute ක්ෂේත්‍රයට :values සඳහා ඇතුල්කිරීම් තිබිය යුතුය.',
    'required_if' => ':attribute ක්ෂේත්‍රය :other :value වන විට අවශ්‍යයි.',
    'required_if_accepted' => ':attribute ක්ෂේත්‍රය :other පිළිගත් විට අවශ්‍යයි.',
    'required_unless' => ':attribute ක්ෂේත්‍රය :other :values තුළ නොමැති නම් අවශ්‍යයි.',
    'required_with' => ':attribute ක්ෂේත්‍රය :values පවතින විට අවශ්‍යයි.',
    'required_with_all' => ':attribute ක්ෂේත්‍රය :values පවතින විට අවශ්‍යයි.',
    'required_without' => ':attribute ක්ෂේත්‍රය :values පවතින විට අවශ්‍යයි.',
    'required_without_all' => ':attribute ක්ෂේත්‍රය :values කිසිවක් පවතින්නේ නැත්නම් අවශ්‍යයි.',
    'same' => ':attribute ක්ෂේත්‍රය :other සමඟ ගැලපිය යුතුය.',
    'size' => [
        'array' => ':attribute ක්ෂේත්‍රයට :size අයිතම තිබිය යුතුය.',
        'file' => ':attribute ක්ෂේත්‍රය :size කිලෝබයිට් තිබිය යුතුය.',
        'numeric' => ':attribute ක්ෂේත්‍රය :size විය යුතුය.',
        'string' => ':attribute ක්ෂේත්‍රයට :size අකුරු තිබිය යුතුය.',
    ],
    'starts_with' => ':attribute ක්ෂේත්‍රය :values වලින් එකක් සමඟ ආරම්භ විය යුතුය.',
    'string' => ':attribute ක්ෂේත්‍රය පද පෙළක් විය යුතුය.',
    'timezone' => ':attribute ක්ෂේත්‍රය වලංගු වේලා කලාපයක් විය යුතුය.',
    'unique' => ':attribute දැනටමත් ලබාගෙන ඇත.',
    'uploaded' => ':attribute උඩුගත කිරීම අසාර්ථක විය.',
    'uppercase' => ':attribute ක්ෂේත්‍රය විශාල අකුරු තිබිය යුතුය.',
    'url' => ':attribute ක්ෂේත්‍රය වලංගු URL එකක් විය යුතුය.',
    'ulid' => ':attribute ක්ෂේත්‍රය වලංගු ULID විය යුතුය.',
    'uuid' => ':attribute ක්ෂේත්‍රය වලංගු UUID විය යුතුය.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
