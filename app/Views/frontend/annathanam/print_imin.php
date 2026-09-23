<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mui/3.7.1/js/mui.min.js"
        integrity="sha512-5LSZkoyayM01bXhnlp2T6+RLFc+dE4SIZofQMxy/ydOs3D35mgQYf6THIQrwIMmgoyjI+bqjuuj4fQcGLyJFYg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/imin-printer-2.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/dom-to-image.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/vConsole/3.9.1/vconsole.min.js"></script>
    <div style="width: 150mm;font-weight: 600;font-family: monospace;" id="archanai_ticket">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="<?php echo base_url(); ?>/assets/css/Barlow.css" rel="stylesheet">
        <style>
            body {
                font-family: 'Barlow', sans-serif;
                background: #fff;
                box-sizing: border-box;
            }

            table {
                border-collapse: collapse;
            }

            table td {
                padding: 5px;
            }

            hr {
                border: none;
                border-top: 1px dashed #000;
                color: #fff;
                background-color: #fff;
                height: 1px;
            }

            p {
                font-size: 20px;
                text-align: center;
                font-weight: 600;
                font-family: monospace;
                margin: 0px
            }

            h3 {
                font-size: 32px;
                text-align: center;
                font-weight: 600;
                font-family: monospace;
                text-transform: uppercase;
            }

            tr td,
            tr th {
                font-size: 20px;
            }

            #archanai_ticket {
                color: #000;
                background: #fff;
                padding: 5px;
                display: block;
            }

            #archanai_loader {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 100%;
                height: 100%;
            }

            img {
                max-width: 100%;
            }
        </style>

        <p style="border-bottom: 3px dotted #9E9E9E;max-width: 150mm;"></p>
        <h3 style="max-width: 150mm;margin: 5px 0;">Customer Copy</h3>
        <p style="border-bottom: 3px dotted #9E9E9E;max-width: 150mm;"></p>
        <br>

        <p><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $temp_details['image']; ?>" style="width:120px;" align="center"></p>
        <h2 style="text-align:center; margin:0"><?php echo $temp_details['name']; ?></h2>
        <p><?php echo $temp_details['address1']; ?>, <?php echo $temp_details['address2']; ?></br>
            <?php echo $temp_details['city'] . '-' . $temp_details['postcode']; ?>.
            Tel: <?= $temp_details['telephone']; ?><?php if (!empty($temp_details['tax_name']) && !empty($temp_details['tax_no'])): ?>
                <br><?= $temp_details['tax_name']; ?> -
                <?= $temp_details['tax_no']; ?>
            <?php endif; ?></p>
        <hr>
        <p style="text-align: center; font-size:28px;">Annathanam Receipt</p>
        <hr>
        <p><b>booked Date : </b><?php $date = new DateTime($qry1['date']); echo $date->format('d-m-Y'); ?></p> 
        <p><b>Annathanam Date : </b><?php echo !empty($qry1['event_date']) ? date('d-m-Y', strtotime($qry1['event_date'])) : ''; ?></p>
        <p><b>Invoice : </b><?php echo $qry1['ref_no']; ?></p>
        <p><b>Name : </b><?php echo $qry1['name']; ?></p>

        <p style="border-bottom: 3px dotted #9E9E9E;max-width: 150mm;"></p>
        <h1 style="text-align:center;"><?php echo $package['name_eng']; ?></h1> <br>
        <p style="border-bottom: 3px dotted #9E9E9E;max-width: 150mm;"></p>
        
        <div class="table-responsive col-md-12" style="margin-bottom:20px;">
            <table align="center" class="table protable table-bordered table-striped table-hover">
                <tr>
                    <td><p style="text-align: left">Items</p></td>
                    <td>:</td>
                    <td><p style="text-align: left"><?php echo htmlspecialchars($package_names, ENT_QUOTES, 'UTF-8'); ?></p></td>
                </tr>
                <tr>
                    <td><p style="text-align: left">Quantity</p></td>
                    <td>:</td>
                    <td><p style="text-align: left"><?php echo $qry1['no_of_pax']; ?></p></td>
                </tr>
                <tr>
                    <td><p style="text-align: left">Amount per pax</td>
                    <td>:</td>
                    <td><p style="text-align: left"><?php echo $package['amount']; ?></p></td>
                </tr>
                <tr>
                    <td><p style="text-align: left">Total</p></p></td>
                    <td>:</td>
                    <td><p style="text-align: left"><?php echo $qry1['sub_total']; ?></p></td>
                </tr>
            </table>
        </div>
            
		<?php
		if(!empty($qry1['discount_amount'])){
			if($qry1['discount_amount'] != '0.00'){ ?>
			<p><b>Discount(RM) : </b>
				<?php echo number_format($qry1['discount_amount'], '2', '.', ','); ?>
			</p>
		<?php 
			}
		}
		?>
        <p><b>Paid Amount : </b>
            <?php echo number_format($qry1['paid_amount'], '2', '.', ','); ?>
        </p>
        <p><b>Balance Amount : </b>
        <?php
        $amount = $qry1['amount'];
        $paid_amount = $qry1['paid_amount'];
        $balance_amount = $amount - $paid_amount;
        ?>
        <?php echo number_format($balance_amount, '2', '.', ','); ?>
        
    </p>
        <hr>

        <br>
        <br>

        <p><span>---</span>GRASP SOFTWARE SOLUTIONS SDN. BHD.<span>---</span></p>
        <hr>
        <br>
    </div>
    <div class="archanai_loader">
        <img src="<?php echo base_url(); ?>/assets/images/loader.gif" />
    </div>
    <?php /* <img src="" id="test_img" /> */ ?>
    <?php /* <div>
   <button class="btn btn-primary" id="web_print">Web Print</button>
   <button class="btn btn-success" id="imin_print">Imin Print</button>
</div> */ ?>
    <script>
        var vConsole = new VConsole();
        function printDiv() {

            var divToPrint = document.getElementById('archanai_ticket');

            var newWin = window.open('', 'Print-Window');

            newWin.document.open();

            newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

            newWin.document.close();

            setTimeout(function () { newWin.close(); }, 1500);

        }
        $(document).ready(function () {
            $(document).on('click', '#web_print', function () {
                printDiv();
            });
            /* var node = document.getElementById('archanai_ticket');
            domtoimage.toJpeg(node).then(function (dataUrl) {
                $('#test_img').attr('src', dataUrl);
            }); */
        });
        var IminPrintInstance = new IminPrinter();
        console.log('IminPrintInstance');
        console.log(IminPrintInstance);
        IminPrintInstance.connect().then(async (isConnect) => {
            if (isConnect) {
                $('.archanai_loader').hide();
                $('#archanai_ticket').show();
                console.log(await IminPrintInstance.getPrinterStatus());
                var QrCodeSize;
                //mui('body').on('tap', '#imin_print', async function (e) {
                IminPrintInstance.initPrinter();
                console.log(await IminPrintInstance.getPrinterStatus());
                var node = document.getElementById('archanai_ticket');
                domtoimage.toJpeg(node).then(function (dataUrl) {
                    IminPrintInstance.printSingleBitmap(dataUrl).then(() => {
                        console.log('sucess');
                        IminPrintInstance.printAndFeedPaper(100);
                        IminPrintInstance.partialCut();
                        setTimeout(function () { window.close(); }, 500);
                        //setTimeout(function(){print_queue(IminPrintInstance, ticket, i + 1);},1000);
                    });
                    /* setTimeout(function(){window.close();}, 1500); */
                });
                //});
            } else {
                alert('error printer');
            }
        });
    </script>
</body>