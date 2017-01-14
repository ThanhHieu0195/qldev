<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_TASK, F_TASK_CREATE_TASK, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Tạo công việc</title>
        <?php require_once '../part/cssjs_1.10.4.php'; ?>
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        
        <!--   <link rel="stylesheet" href="../resources/chosen/docsupport/prism.css"> -->
        <link rel="stylesheet" href="../resources/chosen/chosen.css">
        <style type="text/css" media="all">
          /* fix rtl for demo */
          .chosen-rtl .chosen-drop { left: -9000px; }
        </style>
        <style type="text/css">
            .name { color: blue; font-weight: bolder; }
            .ui-autocomplete-loading {
                background: white url('../resources/images/loading.gif') right center no-repeat !important;
            }
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #main-content tbody tr.alt-row { background: none; }
            .fixed-dialog{ top: 8% !important; left: 20% !important; }
            table.dataTable { margin: 0 auto; clear: both; width: 100% !important;}
            .ui-dialog-titlebar-close { visibility: hidden; }
            #dt_example span { font-weight: normal !important; }
            img { vertical-align: middle; }
            #notification_msg span { font-size: 13px; }
        </style>
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/create-task.js"></script>
    </head>
    <body>
        <div id="body-wrapper">
            <?php
            require_once '../part/menu.php';
            ?>
            <div id="main-content">
                <noscript>
                    <div class="notification error png_bg">
                        <div>
                            Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                        </div>
                    </div>
                </noscript>
                <div class="clear"></div>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thông tin công việc</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                            <form id="create_task" enctype="multipart/form-data" action="../ajaxserver/task_create_task.php" method="post" target="hidden_upload">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td colspan="2">
                                                <input type="radio" name="create_type" value="0" id="create_new" checked="checked" onclick="showTemplateList(false);"> <span class='bold' style="color:rgb(22,167,101);">Tạo công việc mới</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="radio" name="create_type" value="1" id="create_from_template" onclick="showTemplateList(true);"> <span class='blue-text bold'>Tạo công việc từ mẫu có sẵn</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%">
                                                <input type="hidden" id="template_id" name="template_id" value="" />
                                                <label for="title">Tiêu đề (*)</label>
                                            </td>
                                            <td>
                                                <input type="text" name="title" id="title" class="text-input medium-input" maxlength="100"
                                                       value="" />
                                                <span class="error_icon input-notification error png_bg" id="error_title" title="Nhập dữ liệu"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="content">Nội dung (*)</label>
                                            </td>
                                            <td>
                                                <textarea name="content" id="content" rows="5" cols="10"></textarea>
                                                <span class="error_icon input-notification error png_bg" id="error_content" title="Nhập dữ liệu"></span>
                                            </td>
                                        </tr>
                                        <script type="text/javascript" charset="utf-8">
                                            var countId = 0;
                                        </script>
                                        <tr>
                                            <td><label>Danh sách công việc nhỏ cần thực hiện (nếu có):</label></td>
                                            <td>
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th width="10%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="task_detail_list">
                                                        <tr>
                                                            <td>
                                                                <input name="detail_list[]" class="text-input medium-input" style="width: 95% !important" type="text" value="">
                                                            </td>
                                                            <td>
                                                                 <a href="javascript:addRow()" title="Thêm dòng mới"><img src="../resources/images/icons/add.png" alt="Add"></a>
                                                                 <a id="clear_0" href="javascript:clearRow('clear_0')" title="Clear dòng này"><img src="../resources/images/icons/clear.png" alt="Clear"></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="clear"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="assign_to">Người thực hiện (*)</label>
                                            </td>
                                            <td>
                                                <select name="assign_to[]" id="assign_to" data-placeholder=" " class="chosen-select" multiple style="width:350px;" tabindex="4">
                                                    <option value=""></option>
                                                    <?php 
                                                    require_once '../models/nhanvien.php';
                                                    
                                                    $nhanvien = new nhanvien();
                                                    $arr = $nhanvien->employee_list();
                                                    if(is_array($arr)):
                                                        foreach ($arr as $item):
                                                            echo "<option value=\"{$item['manv']}\">{$item['hoten']}</option>";
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </select>
                                                <span class="error_icon input-notification error png_bg" id="error_assign_to" title="Nhập dữ liệu"></span>
                                                <br><small>Những người thực hiện công việc.</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>Thời hạn hoàn thành (*):</label>
                                            </td>
                                            <td>
                                                <input id="deadline" name="deadline" class="text-input small-input" style="width: 150px !important" type="text" readonly="readonly" value="">
                                                <span class="error_icon input-notification error png_bg" id="error_deadline" title="Nhập dữ liệu"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>Lặp lại</label>
                                            </td>
                                            <td>
                                                <input type="radio" name="repeat" id="repeat_no" value="0" checked="checked"> Không
                                                <input type="radio" name="repeat" id="repeat_yes" value="1"> Có
                                                <div style="padding-bottom: 10px;"></div>
                                                <div id="repeat_panel" class="notification attention png_bg" style="display: block;">
                                                    <div>
                                                        <fieldset>
                                                            <p>
                                                                <label for="repeat_times">Số lần lặp (*):</label>
                                                                <input type="text" name="repeat_times" id="repeat_times" class="text-input small-input" 
                                                                       style="width: 50px !important" maxlength="4" value="1" />
                                                                <span class="error_icon input-notification error png_bg" id="error_repeat_times" title="Nhập dữ liệu"></span>
                                                                <br />
                                                            </p>
                                                            <p>
                                                                <label>Lặp lại theo:</label><br />
                                                                <input type="radio" name="repeat_by" id="repeat_by_daily" value="1" checked="checked"> Ngày
                                                                <br />
                                                                <input type="radio" name="repeat_by" id="repeat_by_weekly" value="2"> Tuần (theo thứ)
                                                                <select name="weekly" id="weekly" style="display: none;">
                                                                    <option value=""></option>
                                                                    <option value="0">Thứ hai</option>
                                                                    <option value="1">Thứ ba</option>
                                                                    <option value="2">Thứ tư</option>
                                                                    <option value="3">Thứ năm</option>
                                                                    <option value="4">Thứ sáu</option>
                                                                    <option value="5">Thứ bảy</option>
                                                                    <option value="6">Chủ nhật</option>
                                                                </select>
                                                                <span class="error_icon input-notification error png_bg" id="error_weekly" title="Nhập dữ liệu"></span>
                                                                <br />
                                                                <input type="radio" name="repeat_by" id="repeat_by_monthly" value="3"> Tháng (theo ngày)
                                                                <select name="monthly" id="monthly" style="display: none;">
                                                                    <option value=""></option>
                                                                    <?php for ($i = 1; $i <= 31; $i++): ?>
                                                                    <option value="<?php echo $i; ?>>"><?php echo $i; ?></option>
                                                                    <?php endfor; ?>
                                                                </select>
                                                                <span class="error_icon input-notification error png_bg" id="error_monthly" title="Nhập dữ liệu"></span>
                                                                <br />
                                                            </p>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>File đính kèm</label>
                                            </td>
                                            <td>
                                                <input type="file" id="attachment_file" name="attachment_file" lang="en" class="file_upload" />
                                                <span class="error_icon input-notification error png_bg" id="error_attachment_file" title="Nhập dữ liệu"></span>
                                                <br><small>Vui lòng chọn file đính kèm</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">
                                                <div class="bulk-actions align-left"></div>
                                                <div class="clear"></div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="clear"></div>
                                <fieldset>
                                    <p>
                                        <input type="submit" class="button" value="Tạo công việc" name="submit">
                                        <input type="reset" class="button" value="Làm lại" id="reset" name="reset">
                                        <span id="attention" style="color: red;">Có một số trường dữ liệu chưa đúng. Vui lòng kiểm tra lại!</span>
                                    </p>
                                </fieldset>
                                <div id="notification_msg">
                                </div>
                                <script src="../resources/chosen/chosen.jquery.js" type="text/javascript"></script>
                                <script src="../resources/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
                                <script type="text/javascript">
                                    var config = {
                                      '.chosen-select'           : {},
                                      '.chosen-select-deselect'  : {allow_single_deselect:true},
                                      '.chosen-select-no-single' : {disable_search_threshold:10},
                                      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                                      '.chosen-select-width'     : {width:"95%"}
                                    };
                                    for (var selector in config) {
                                      $(selector).chosen(config[selector]);
                                    }
                                </script>
                                <iframe id="hidden_upload" name="hidden_upload" src="" onload="uploadDone('hidden_upload');" 
                                        style="width:0;height:0;border:0px solid #fff">
                                </iframe>
                                <div class="clear"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
        <!-- Dialog -->
        <div id="template_panel" title="Danh sách công việc mẫu">
            <div id="dt_example">
                <div id="container">
                    <div id="demo">
                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tiêu đề</th>
                                    <th>Nội dung</th>
                                    <th>Chọn</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="ajax-loader" style="display: none;"><img src="../resources/images/loadig_big.gif" /> <span style="color: black;">Loading...</span></div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>