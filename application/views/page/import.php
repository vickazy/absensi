<!-- Main content -->
<section class="content">
  <!-- Info boxes -->
  <div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">File Upload</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="post" enctype="multipart/form-data" action="<?php echo base_url('UploadImport/doUpload'); ?>">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Sekolah</label>
                        <select name="sekolahID" class="form-control" required>
                            <?php
                                echo "<option value=''>-- Pilih --</option>";
                            foreach ($listSekolah as $key){
                                echo "<option value='".$key['idSekolah']."'>".$key['nama']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <input id="exampleInputFile" type="file" required name="file">

                        <p class="help-block">File must in .sql</p>
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
  </div>
  <!-- /.row -->
  
</section>
<!-- /.content -->