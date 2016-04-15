
<div class="form-group">
    <label class="col-md-3 control-label"><?php echo $field->field_label; ?>
        <?php if ($field->validation->required == 1) { ?>
            <span class="required" aria-required="true"> * </span>
        <?php } ?>
    </label>
    <div class="col-md-9">
        <input 
            type="<?php echo ($field->validation->field_type != NULL)?$field->validation->field_type:'text'; ?>" 
            class="form-control <?php echo $field->html_css; ?>" 
            <?php  echo ($field->validation->required == 1)?'required':''; ?> 
            placeholder="<?php echo $field->placheorder; ?>"
            <?php echo ($field->validation->min_length > 0)?'minlength="'.$field->validation->min_length.'"':''; ?>
            name="<?php echo $field->field_name; ?>"
            value="<?php echo $value; ?>"
            >
        
        
        <?php if ($field->help != null) { ?>
            <span class="help-block"> <?php echo $field->help; ?></span>
        <?php } ?>
        <div id="invalid-<?php echo $field->field_name; ?>"></div>
    </div>
</div>

