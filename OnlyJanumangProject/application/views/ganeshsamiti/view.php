<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> गणेश समिति प्रबंधन
        <small>गणेश समिति विवरण देखें</small>
      </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">गणेश समिति विवरण</h3>
                        <div class="box-tools pull-right">
                            <a href="<?php echo base_url(); ?>ganeshsamiti" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> वापस जाएं</a>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-bordered">
                            <tr>
                                <td class="col-md-3"><b>क्र.</b></td>
                                <td class="col-md-9"><?php echo $ganeshSamitiInfo[0]->serial_number; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>वर्ष</b></td>
                                <td class="col-md-9"><?php echo $ganeshSamitiInfo[0]->year; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>गणेश समिति का नाम</b></td>
                                <td class="col-md-9"><?php echo $ganeshSamitiInfo[0]->ganesh_samiti_name; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>ब्लॉक</b></td>
                                <td class="col-md-9"><?php echo $ganeshSamitiInfo[0]->block_name; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>सेक्टर</b></td>
                                <td class="col-md-9"><?php echo $ganeshSamitiInfo[0]->sector; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>माइक्रो सेक्टर नंबर</b></td>
                                <td class="col-md-9"><?php echo $ganeshSamitiInfo[0]->micro_sector_number; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>माइक्रो सेक्टर नाम</b></td>
                                <td class="col-md-9"><?php echo $ganeshSamitiInfo[0]->micro_sector_name; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>बूथ नंबर</b></td>
                                <td class="col-md-9"><?php echo $ganeshSamitiInfo[0]->booth_number; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>बूथ नाम</b></td>
                                <td class="col-md-9"><?php echo $ganeshSamitiInfo[0]->booth_name; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>पंचायत</b></td>
                                <td class="col-md-9"><?php echo $ganeshSamitiInfo[0]->panchayat; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>ग्राम</b></td>
                                <td class="col-md-9"><?php echo $ganeshSamitiInfo[0]->gram; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>फलिया</b></td>
                                <td class="col-md-9"><?php echo $ganeshSamitiInfo[0]->faliya; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>सदस्य का नाम</b></td>
                                <td class="col-md-9"><?php echo $ganeshSamitiInfo[0]->member_name; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>पिता का नाम</b></td>
                                <td class="col-md-9"><?php echo $ganeshSamitiInfo[0]->father_name; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>उम्र</b></td>
                                <td class="col-md-9"><?php echo $ganeshSamitiInfo[0]->age; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>पद</b></td>
                                <td class="col-md-9"><?php echo $ganeshSamitiInfo[0]->position; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>मोबाइल नंबर</b></td>
                                <td class="col-md-9"><?php echo $ganeshSamitiInfo[0]->mobile_number; ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><b>रिमार्क</b></td>
                                <td class="col-md-9"><?php echo $ganeshSamitiInfo[0]->remark; ?></td>
                            </tr>
                        </table>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <div class="pull-right">
                            <a href="<?php echo base_url(); ?>ganeshsamiti/edit/<?php echo $ganeshSamitiInfo[0]->id; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> संपादित करें</a>
                            <a href="<?php echo base_url(); ?>ganeshsamiti" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> वापस जाएं</a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</div>