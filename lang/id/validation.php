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

    'accepted'             => ':attribute harus diterima.',
    'accepted_if'          => ':attribute harus diterima saat :other adalah :value.',
    'active_url'           => ':attribute harus berupa URL yang valid.',
    'after'                => ':attribute harus berupa tanggal setelah :date.',
    'after_or_equal'       => ':attribute harus berupa tanggal setelah atau sama dengan :date.',
    'alpha'                => ':attribute hanya boleh berisi huruf.',
    'alpha_dash'           => ':attribute hanya boleh berisi huruf, angka, dan tanda hubung.',
    'alpha_num'            => ':attribute hanya boleh berisi huruf dan angka.',
    'array'                => ':attribute harus berupa array.',
    'before'               => ':attribute harus berupa tanggal sebelum :date.',
    'before_or_equal'      => ':attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between'              => [
        'numeric' => ':attribute harus antara :min dan :max.',
        'file'    => ':attribute harus antara :min dan :max kilobytes.',
        'string'  => ':attribute harus antara :min dan :max karakter.',
        'array'   => ':attribute harus memiliki antara :min dan :max item.',
    ],
    'boolean'              => ':attribute harus berupa true atau false.',
    'confirmed'            => 'Konfirmasi :attribute tidak sesuai.',
    'current_password'     => 'Kata sandi tidak sesuai.',
    'date'                 => ':attribute harus berupa tanggal yang valid.',
    'date_equals'          => ':attribute harus berupa tanggal yang sama dengan :date.',
    'date_format'          => ':attribute tidak sesuai format :format.',
    'declined'             => ':attribute harus ditolak.',
    'declined_if'          => ':attribute harus ditolak saat :other adalah :value.',
    'different'            => ':attribute dan :other harus berbeda.',
    'digits'               => ':attribute harus berupa :digits digit.',
    'digits_between'       => ':attribute harus memiliki antara :min dan :max digit.',
    'dimensions'           => ':attribute memiliki dimensi gambar yang tidak valid.',
    'distinct'             => ':attribute memiliki nilai yang duplikat.',
    'email'                => ':attribute harus berupa alamat email yang valid.',
    'ends_with'            => ':attribute harus diakhiri dengan salah satu: :values.',
    'exists'               => ':attribute yang dipilih tidak valid.',
    'file'                 => ':attribute harus berupa file.',
    'filled'               => ':attribute harus memiliki nilai.',
    'gt'                   => [
        'numeric' => ':attribute harus lebih besar dari :value.',
        'file'    => ':attribute harus lebih besar dari :value kilobytes.',
        'string'  => ':attribute harus lebih panjang dari :value karakter.',
        'array'   => ':attribute harus lebih dari :value item.',
    ],
    'gte'                  => [
        'numeric' => ':attribute harus lebih besar atau sama dengan :value.',
        'file'    => ':attribute harus lebih besar atau sama dengan :value kilobytes.',
        'string'  => ':attribute harus sepanjang atau lebih panjang dari :value karakter.',
        'array'   => ':attribute harus memiliki :value item atau lebih.',
    ],
    'image'                => ':attribute harus berupa gambar.',
    'in'                   => ':attribute yang dipilih tidak valid.',
    'in_array'             => ':attribute harus ada di :other.',
    'integer'              => ':attribute harus berupa integer.',
    'ip'                   => ':attribute harus berupa alamat IP yang valid.',
    'ipv4'                 => ':attribute harus berupa alamat IPv4 yang valid.',
    'ipv6'                 => ':attribute harus berupa alamat IPv6 yang valid.',
    'json'                 => ':attribute harus berupa JSON yang valid.',
    'lt'                   => [
        'numeric' => ':attribute harus kurang dari :value.',
        'file'    => ':attribute harus kurang dari :value kilobytes.',
        'string'  => ':attribute harus kurang dari :value karakter.',
        'array'   => ':attribute harus kurang dari :value item.',
    ],
    'lte'                  => [
        'numeric' => ':attribute harus kurang atau sama dengan :value.',
        'file'    => ':attribute harus kurang atau sama dengan :value kilobytes.',
        'string'  => ':attribute harus sepanjang atau kurang dari :value karakter.',
        'array'   => ':attribute harus tidak lebih dari :value item.',
    ],
    'max'                  => [
        'numeric' => ':attribute maksimal :max.',
        'file'    => ':attribute maksimal :max kilobytes.',
        'string'  => ':attribute maksimal :max karakter.',
        'array'   => ':attribute maksimal memiliki :max item.',
    ],
    'mimes'                => ':attribute harus berupa file dengan tipe: :values.',
    'mimetypes'            => ':attribute harus berupa file dengan tipe: :values.',
    'min'                  => [
        'numeric' => ':attribute minimal :min.',
        'file'    => ':attribute minimal :min kilobytes.',
        'string'  => ':attribute minimal :min karakter.',
        'array'   => ':attribute minimal memiliki :min item.',
    ],
    'multiple_of'          => ':attribute harus merupakan kelipatan :value.',
    'not_in'               => ':attribute yang dipilih tidak valid.',
    'not_regex'            => 'Format :attribute tidak valid.',
    'numeric'              => ':attribute harus berupa angka.',
    'password'             => 'Kata sandi tidak sesuai.',
    'present'              => ':attribute harus ada.',
    'regex'                => 'Format :attribute tidak valid.',
    'required'             => ':attribute wajib diisi.',
    'required_if'          => ':attribute wajib diisi saat :other adalah :value.',
    'required_unless'      => ':attribute wajib diisi kecuali :other adalah :values.',
    'required_with'        => ':attribute wajib diisi saat :values ada.',
    'required_with_all'    => ':attribute wajib diisi saat :values ada.',
    'required_without'     => ':attribute wajib diisi saat :values tidak ada.',
    'required_without_all' => ':attribute wajib diisi saat tidak ada :values.',
    'same'                 => ':attribute dan :other harus sama.',
    'size'                 => [
        'numeric' => ':attribute harus :size.',
        'file'    => ':attribute harus :size kilobytes.',
        'string'  => ':attribute harus :size karakter.',
        'array'   => ':attribute harus memiliki :size item.',
    ],
    'starts_with'          => ':attribute harus diawali dengan salah satu: :values.',
    'string'               => ':attribute harus berupa string.',
    'timezone'             => ':attribute harus berupa zona waktu yang valid.',
    'unique'               => ':attribute sudah terdaftar sebelumnya.',
    'uploaded'             => ':attribute gagal diunggah.',
    'url'                  => 'Format :attribute tidak valid.',
    'uuid'                 => ':attribute harus berupa UUID yang valid.',

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
    | The following language lines are used to swap our attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
