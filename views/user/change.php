<h1>Change user information</h1>
<form action="../../index.php" method="post" class="form-change">
    <input type="hidden" name="id_user" id="id_user" value="<?=$id?>">
    <label for="name" class="input-label">User first and last name</label>
    <input type="text" name="name" id="name" class="form-control-sm" value="<?=$name?>">
    </div>
    <div class="form-group">
    <label for="email" class="input-label">Email address</label>
    <input type="email" name="email" class="form-control-sm" id="email" value="<?=$email?>">
    </div>
    <label for="gender" class="mt-3">
        <select class="selectpicker btn btn-primary btn-sm" name="gender" id="gender">
            <?php
                $selectedFirst = '';
                $selectedSecond = '';
                if ($gender === 'male')
                    $selectedFirst = 'selected';
                else
                    $selectedSecond = 'selected';
            ?>
            <option value="male" <?=$selectedFirst?>>Male</option>
            <option value="female" <?=$selectedSecond?>>Female</option>
        </select>
    </label>
    <label for="status" class="mt-3">
        <select class="selectpicker btn btn-primary btn-sm " name="status" id="status">
            <?php
                $selectedFirst = '';
                $selectedSecond = '';
                if ($status === 'active') $selectedFirst = 'selected';
                else $selectedSecond = 'selected';
            ?>
            <option value="active" <?=$selectedFirst?>>Active</option>
            <option value="inactive" <?=$selectedSecond?>>Inactive</option>
        </select>
    </label>
  <div class="form-group">
    <button type="submit" class="btn btn-primary" >Save</button>
  </div>
</form>
<script type="module" src="views/js/ValidationClass.js"></script>
<script type="module" src="views/js/funcForValidation.js"></script>
<script type="module" src="views/js/changeValidation.js"></script>


