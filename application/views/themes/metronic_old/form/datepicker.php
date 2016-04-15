
<div class="form-group">
    <label class="col-md-3 control-label"><?php echo $field->field_label; ?>
        <?php if ($field->validation->required == 1) { ?>
            <span class="required" aria-required="true"> * </span>
        <?php } ?>
    </label>
    <div class="col-md-3">
        <!--<input class="form-control form-control-inline  date-picker" name=""  type="text" />-->
        <input id="mask_date2" <?php echo $field->field_name; ?> 
               class="form-control form-control-inline input-medium" 
               placeholder="dd.mm.rrrr" 
               type="text" 
                name="<?php echo $field->field_name; ?>"
               value="<?php echo $value; ?>" size="16">
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#mask_date2").inputmask("d.m.y", {
            "placeholder": "dd.mm.yyyy"
        });
    });


</script>