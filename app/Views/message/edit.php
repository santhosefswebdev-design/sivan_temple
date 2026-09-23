<section class="content">
    <div class="container-fluid">
			<?php if($_SESSION['succ'] != '') { ?>
                <div class="row" style="padding: 0 30% 2% 30%;" id="content_alert">
                    <div class="suc-alert">
                        <span class="suc-closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p><?php echo $_SESSION['succ']; ?></p> 
                    </div>
                </div>
            <?php } ?>
            <?php if($_SESSION['fail'] != '') { ?>
                <div class="row" style="padding: 0 30% 2% 30%;" id="content_alert">
                    <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <p><?php echo $_SESSION['fail']; ?></p>
                    </div>
                </div>
            <?php } ?>
            <div class="block-header">
            <h2>PROFILE<small>Message / <a href="#" target="_blank">Message Setting</a></small></h2>
        </div>
		
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row"><div class="col-md-8"><h2>Message Setting</h2></div>
                        <div class="col-md-4" align="right"></div></div>
                    </div>
                    <form action="<?php echo base_url(); ?>/message/save" method="POST" enctype="multipart/form-data">
                    <div class="body">
                        <div class="container-fluid">
                        <div class="row clearfix">
							<div class="col-sm-12" style="margin: 0px;">
								<h3 style="margin: 0px 0 10px 0;font-weight: 500;">Hall</h3>
							</div>
                            <div class="col-sm-12" style="margin: 0px;">
                                <div class="form-group form-float">
                                    <div class="form-line">
										<textarea name="hall_editor" id="hall_editor" cols="30" rows="10" required><?php echo $message['hall'];?></textarea>
                                    </div>
                                </div>
                            </div>
							
							<div class="col-sm-12" style="margin: 0px;">
								<h3 style="margin: 0px 0 10px 0;font-weight: 500;">Cash Donation</h3>
							</div>
                            <div class="col-sm-12" style="margin: 0px;">
                                <div class="form-group form-float">
                                    <div class="form-line">
										<textarea name="cash_donation_editor" id="cash_donation_editor" cols="30" rows="10" required><?php echo $message['cash_donation'];?></textarea>
                                    </div>
                                </div>
                            </div>
							
							<div class="col-sm-12" style="margin: 0px;">
								<h3 style="margin: 0px 0 10px 0;font-weight: 500;">Product Donation</h3>
							</div>
                            <div class="col-sm-12" style="margin: 0px;">
                                <div class="form-group form-float">
                                    <div class="form-line">
										<textarea name="product_donation_editor" id="product_donation_editor" cols="30" rows="10" required><?php echo $message['product_donation'];?></textarea>
                                    </div>
                                </div>
                            </div>
							
							<div class="col-sm-12" style="margin: 0px;">
								<h3 style="margin: 0px 0 10px 0;font-weight: 500;">Ubayam</h3>
							</div>
                            <div class="col-sm-12" style="margin: 0px;">
                                <div class="form-group form-float">
                                    <div class="form-line">
										<textarea name="ubayam_editor" id="ubayam_editor" cols="30" rows="10" required><?php echo $message['ubayam'];?></textarea>
                                    </div>
                                </div>
                            </div>
							
							<div class="col-sm-12" style="margin: 0px;">
								<h3 style="margin: 0px 0 10px 0;font-weight: 500;">Common</h3>
							</div>
                            <div class="col-sm-12" style="margin: 0px;">
                                <div class="form-group form-float">
                                    <div class="form-line">
										<textarea name="common_editor" id="common_editor" cols="30" rows="10" required><?php echo $message['common'];?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12" align="center">
                                <button type="submit" class="btn btn-success btn-lg waves-effect">UPDATE</button>
                            </div>
                        </div>
                    </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.8.0/full-all/ckeditor.js"></script>
<script>
CKEDITOR.replace('hall_editor', {
  skin: 'moono',
  enterMode: CKEDITOR.ENTER_BR,
  shiftEnterMode:CKEDITOR.ENTER_P,
  toolbar: [{ name: 'basicstyles', groups: [ 'basicstyles' ], items: [ 'Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor' ] },
             { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
             { name: 'scripts', items: [ 'Subscript', 'Superscript' ] },
             { name: 'justify', groups: [ 'blocks', 'align' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
             { name: 'paragraph', groups: [ 'list', 'indent' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
            /* { name: 'links', items: [ 'Link', 'Unlink' ] },
             { name: 'insert', items: [ 'Image'] },*/
             { name: 'spell', items: [ 'jQuerySpellChecker' ] },
             { name: 'table', items: [ 'Table' ] }
             ],
});
CKEDITOR.replace('cash_donation_editor', {
  skin: 'moono',
  enterMode: CKEDITOR.ENTER_BR,
  shiftEnterMode:CKEDITOR.ENTER_P,
  toolbar: [{ name: 'basicstyles', groups: [ 'basicstyles' ], items: [ 'Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor' ] },
             { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
             { name: 'scripts', items: [ 'Subscript', 'Superscript' ] },
             { name: 'justify', groups: [ 'blocks', 'align' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
             { name: 'paragraph', groups: [ 'list', 'indent' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
             { name: 'spell', items: [ 'jQuerySpellChecker' ] },
             { name: 'table', items: [ 'Table' ] }
             ],
});
CKEDITOR.replace('product_donation_editor', {
  skin: 'moono',
  enterMode: CKEDITOR.ENTER_BR,
  shiftEnterMode:CKEDITOR.ENTER_P,
  toolbar: [{ name: 'basicstyles', groups: [ 'basicstyles' ], items: [ 'Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor' ] },
             { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
             { name: 'scripts', items: [ 'Subscript', 'Superscript' ] },
             { name: 'justify', groups: [ 'blocks', 'align' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
             { name: 'paragraph', groups: [ 'list', 'indent' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
             { name: 'spell', items: [ 'jQuerySpellChecker' ] },
             { name: 'table', items: [ 'Table' ] }
             ],
});
CKEDITOR.replace('ubayam_editor', {
  skin: 'moono',
  enterMode: CKEDITOR.ENTER_BR,
  shiftEnterMode:CKEDITOR.ENTER_P,
  toolbar: [{ name: 'basicstyles', groups: [ 'basicstyles' ], items: [ 'Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor' ] },
             { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
             { name: 'scripts', items: [ 'Subscript', 'Superscript' ] },
             { name: 'justify', groups: [ 'blocks', 'align' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
             { name: 'paragraph', groups: [ 'list', 'indent' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
             { name: 'spell', items: [ 'jQuerySpellChecker' ] },
             { name: 'table', items: [ 'Table' ] }
             ],
});
CKEDITOR.replace('common_editor', {
  skin: 'moono',
  enterMode: CKEDITOR.ENTER_BR,
  shiftEnterMode:CKEDITOR.ENTER_P,
  toolbar: [{ name: 'basicstyles', groups: [ 'basicstyles' ], items: [ 'Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor' ] },
             { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
             { name: 'scripts', items: [ 'Subscript', 'Superscript' ] },
             { name: 'justify', groups: [ 'blocks', 'align' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
             { name: 'paragraph', groups: [ 'list', 'indent' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
             { name: 'spell', items: [ 'jQuerySpellChecker' ] },
             { name: 'table', items: [ 'Table' ] }
             ],
});
</script>