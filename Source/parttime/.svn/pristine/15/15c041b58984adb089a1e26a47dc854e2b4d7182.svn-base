<?php 
$title = "Thêm dữ liệu chi tiết sản phẩm mapping từ file Excel";

 ?>
 <div class="content-box column-left" style="width:100%">
    <div class="content-box-header">
        <h3><?php echo $title; ?></h3>
    </div>
    <div class="content-box-content" >
        <form action="ajaxserver.php?action=autoupload_chitietsanphammapping" method="post" enctype="multipart/form-data" target="hidden_upload">
            <p>     
                <label>File Excel</label>
                <input type="file" id="upload_scn" name="upload_scn" lang="en" class="file_upload" />
                <br /><small>Vui lòng chọn file Excel thích hợp</small>
            </p>
            <p>
                <a href="../uploads/templates/template_autoupload_chitietsanphammapping.xls">teamplate</a>
            </p>
            <p>
                <input class="button" type="submit" name="submit" value="Upload" />
            </p>
            <iframe id="hidden_upload" name="hidden_upload" src="" onload="uploadDone('hidden_upload');" 
                        style="width:0;height:0;border:0px solid #fff">
            </iframe>
        </form>

        <div class="clear"></div>
        <div style="height: 20px"></div>                                
        <div>
            <div id="upload_notification" class="notification information png_bg" style="display: none">
                <div id="upload_message">
                    Đã thực hiện thêm các sản phẩm từ file. 
                </div>
            </div>
        </div>

    </div>
</div>
          
