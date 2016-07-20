<div id="content">
    <div class="container-fluid"><br />
        <br />
        <div class="row">
            <div class="col-sm-offset-3 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h1 class="panel-title"><i class="fa fa-file"></i> File Manager</h1>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td ><?php if ($sort == 'name') { ?>
                                        <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order_by); ?>">Name</a>
                                        <?php } else { ?>
                                        <a href="<?php echo $sort_name; ?>">Name</a>
                                        <?php } ?>
                                    </td>
                                    <td ><?php if ($sort == 'type') { ?>
                                        <a href="<?php echo $sort_type; ?>" class="<?php echo strtolower($order_by); ?>">Type</a>
                                        <?php } else { ?>
                                        <a href="<?php echo $sort_type; ?>">Type</a>
                                        <?php } ?>
                                    </td>
                                    <td ><?php if ($sort == 'size') { ?>
                                        <a href="<?php echo $sort_size; ?>" class="<?php echo strtolower($order_by); ?>">Size</a>
                                        <?php } else { ?>
                                        <a href="<?php echo $sort_size; ?>">Size</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($folder as $item) { ?>
                                    <?php if($item['type'] == 'error') { ?>
                                        <tr>
                                            <td colspan="3" class="danger"><?php echo $item['name']; ?></td>
                                        </tr>
                                    <?php }elseif($item['type'] == '') { ?>
                                        <tr>
                                            <td><a href="<?php echo $item['href']; ?>"><?php echo $item['name']; ?></a></td>
                                            <td><?php echo $item['type']; ?></td>
                                            <td><?php echo $item['size']; ?></td>
                                        </tr>
                                    <?php }else{  ?>
                                        <tr>
                                            <td><?php echo $item['name']; ?></td>
                                            <td><?php echo $item['type']; ?></td>
                                            <td><?php echo $item['size']; ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
