<style>
table { border-collapse:collapse; }
.inner_table tr:nth-child(even) { background:#F3F3F3; }
.inner_table tr:last-child { background:#e2dfdf; }
.tab tr th, .tab tr td { text-align:center; }
</style>
<table align="center"style="width: 100%;max-width: 800px;">
<tr><td colspan="2">
    <table style="width:100%">
    <tr><td width="15%" align="left"><img src="<?php echo base_url(); ?>/uploads/main/<?php echo $_SESSION['logo_img']; ?>" style="width:120px;" align="left"></td>
    <td width="85%" align="left"><h2 style="text-align:left;margin-bottom: 0;"><?php echo $_SESSION['site_title']; ?></h2>
    <p style="text-align:left; font-size:16px; margin:5px 0px;"><?php echo $_SESSION['address1']; ?>, <br><?php echo $_SESSION['address2']; ?>,<br>
	<?php echo $_SESSION['city']; ?> - <?php echo $_SESSION['postcode']; ?><br>
    Tel : <?php echo $_SESSION['telephone']; ?></p></td></tr>
    </table>
</td></tr>
<tr><td colspan="2"><hr></td></tr>

<?php 
$db = db_connect();

?>
<tr><td colspan="2">
<h3 style="text-align:center;">Account Group List</h3>


    <table class="tab" border="1" width="100%">
        <thead>
            <tr>
                <th >S No.</th>
                <th >Code</th>
                <th >Group Name</th>
                <th >Category</th>
            </tr>
        </thead>
        <tbody>
		<?php			
		$i=1;
			
			//Parent Group
        $parent = $db->query("select * from groups where parent_id is NULL or parent_id =''")->getResultArray();
        foreach($parent as $row){
			?>
			<tr>
				<td style="text-align:right;padding-right:5px"> <?= $i++ ?></span></td>
				<td style="text-align:right;padding-right:5px"> <?= $row['code'] ?></span></td>
				<td style="text-align:left;padding-left:5px"><?= $row['name'] ?></td>
				<td>-</td>
			</tr>
			<?php 
            $id =$row['id'];
            
            // Child Group
            $cgroup = $db->query("select * from groups where parent_id = $id")->getResultArray();
            foreach($cgroup as $crow){
				?>
				<tr>
					<td style="text-align:right;padding-right:5px"> <?= $i++ ?></span></td>
					<td style="text-align:right;padding-right:5px"> <?= $crow['code'] ?></span></td>
					<td style="text-align:left;padding-left:5px"><?= $crow['name'] ?></td>
					<td style="text-align:left;padding-left:5px"><?= $row['name'] ?></td>
					
				</tr>
				<?php
			
                $id =$crow['id'];
                
                // 2nd child
                $mcgroup = $db->query("select * from groups where parent_id = $id")->getResultArray();
                foreach($mcgroup as $mcrow){
					?>
					<tr>
						<td style="text-align:right;padding-right:5px"> <?= $i++ ?></span></td>
						<td style="text-align:right;padding-right:5px"> <?= $mcrow['code'] ?></span></td>
						<td style="text-align:left;padding-left:5px"><?= $mcrow['name'] ?></td>
						<td style="text-align:left;padding-left:5px"><?= $crow['name'] ?></td>
					</tr>
					<?php
                    
                }
            }
        }
		 ?>
        </tbody>
    </table>
</td></tr></table>
<script>
window.print();
</script>
