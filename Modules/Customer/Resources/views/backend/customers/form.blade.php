<div class="row mb-12">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'first_name';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row mb-12">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'last_name';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row mb-12">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'email';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row mb-12">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'password';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->password($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
            {{ html()->hidden('customer_register')->value(1) }}
        </div>
    </div>
</div>


<div class="row mb-12">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'wallet_balance';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->number($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row mb-12">
<div class="col-12 col-sm-4">
    <hr>
</div>
</div>
