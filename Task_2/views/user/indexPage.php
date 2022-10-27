<h1 class="text-primary">Database</h1>
<table class="table table-bordered table-dark table-hover" style="margin-top: 50px;">
    <thead>
        <tr>
            <th scope="col">№</th>
            <th scope="col">FIO</th>
            <th scope="col">Email</th>
            <th scope="col">Gender</th>
            <th scope="col">Status</th>
            <th scope="col">Option</th>
        </tr>
    </thead>
    <?php foreach ($records as $record) : ?>
        <tr scope="row">
            <?php foreach ($record as $value) : ?>
                <td>
                    <?php echo $value ?>
                </td>
            <?php endforeach ;?>
            <td>
                <div class="options">
                    <a href="#" class="btn btn-primary change-btn" data-id="<?=$record['id_user']?>"><span>Modify user information</span></a>
                    <a href="#" class="btn btn-primary delete-btn mb-1" data-id="<?=$record['id_user']?>"><span>Delete user</span></a>
                </div>
            </td>
        </tr>
    <?php endforeach ;?>
</table>
<div class="wrap-btn">
    <a href="#" class="btn-nav btn-nav-left" role="button"><i class="fa fa-arrow-left"></i></a>
    <a href="add" class="btn btn-primary btn-add" role="button"><span>Add user</span></a>
    <a href="#" class="btn-nav btn-nav-right" role="button"><i class="fa fa-arrow-right"></i></a>
</div>
<div id="count" data-count="<?=$count?>" data-current="<?=$currentPage?>"></div>
<!-- Modal window -->
<div class="modal fade" id="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User deletion confirmation</h5>
            </div>
            <div class="modal-body">
                Are you sure that you want to delete this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="close-modal" data-bs-dismiss="modal">Confirm</button>
            </div>
        </div>
    </div>
</div>
<script src="views/js/pagination.js"></script>
<script type="module" src="views/js/deleteUser.js"></script>
<script type="module" src="views/js/changeInfo.js"></script>