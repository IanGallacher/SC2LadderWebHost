<?php
session_start();
	require_once("header.php");



	if(!isset($_REQUEST['author']))
	{
		die("ERROR: invalid request");
	}

	$sql = "SELECT * FROM `members` WHERE `id` = '" . mysqli_real_escape_string($link, $_REQUEST['author']) . "'";

	$result = $link->query($sql);
	if(!$row = $result->fetch_assoc())
	{
		die("unable to get profile" . $sql);
	}
?>
<hr>
<div class="container bootstrap snippet">
    <div class="row">
  		<div class="col-sm-10"><h1><?php echo $row['Alias']; ?></h1></div>
    	<div class="col-sm-2">
		<?php
		if( $row['Avatar'] == "")
		{
			echo "<img title=\"profile image\" class=\"img-circle img-responsive\" src=\"./images/avatar.jpg\">";
		}
		else
		{
			echo "<img title=\"profile image\" class=\"img-circle img-responsive\" src=\"" . $row['Avatar'] . "\">";
		}
		?>
		</div>
    </div>
    <div class="row">
  		<div class="col-sm-3"><!--left col-->
              
          <ul class="list-group">
            <li class="list-group-item text-muted">Profile</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Joined</strong></span> <?php echo $row['Joined']; ?></li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Real name</strong></span> <?php echo $row['Name']; ?></li>
            
          </ul> 
               
          <div class="panel panel-default">
            <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i></div>
            <div class="panel-body"><?php echo "<a href=\"" . $row['Website'] . "\">" . $row['Website'] . "</a>" ?></div>
          </div>
          
          <div class="panel panel-default">
            <div class="panel-heading">Github <i class="fa fa-link fa-1x"></i></div>
            <div class="panel-body"><?php echo "<a href=\"" . $row['Github'] . "\">" . $row['Github'] . "</a>" ?></div>
          </div>
          
        </div><!--/col-3-->
    	<div class="col-sm-9">

          <div class="tab-content">
            <div class="tab-pane active" id="home">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Bot Name</th>
                      <th>Race</th>
                      <th>Season</th>
                      <th>Win Pct</th>
                      <th>Position</th>
                    </tr>
                  </thead>
                  <tbody id="items">
				           <?php
			$sql = "SELECT `participants`.`name` AS BotName, 
			`participants`.`Race` AS BotRace, 
			`seasonids`.`SeasonName` AS SeasonName, 
			`seasons`.`Season` AS Season, 
			`seasons`.`WinPct` AS WinPct, 
			`seasons`.`Position` AS Position 
			FROM `participants`, `seasons`, `seasonids` WHERE `seasons`.`Author` = `participants`.`Author` 
			AND `seasons`.`BotId` = `participants`.`id` 
			AND `seasons`.`Season` = `seasonids`.`id` 
			AND `seasons`.`Author` = '" . mysqli_real_escape_string($link, $_REQUEST['author']) . "' 
			ORDER BY `seasons`.`EndDate` DESC, `seasons`.`Position` ASC";
					
					$botresult = $link->query($sql);
				while($botrow = $botresult->fetch_assoc())
				{
                    echo "<tr>
                      <td>" . $botrow['BotName'] . "</td>
                      <td>" . GetRace($botrow['BotRace']) . "</td>
                      <td>" . $botrow['SeasonName'] . "</td>
                      <td>" . number_format((float)$botrow['WinPct'], 2, '.', '') . "</td>
                      <td>" . $botrow['Position'] . "</td>
                    </tr>";
				}
			  ?>
                  </tbody>
                </table>
                <hr>
                <div class="row">
                  <div class="col-md-4 col-md-offset-4 text-center">
                  	<ul class="pagination" id="myPager"></ul>
                  </div>
                </div>
              </div><!--/table-resp-->
              
              <hr>
              
             </div><!--/tab-pane-->


               

          </div><!--/tab-content-->

        </div><!--/col-9-->
    </div><!--/row-->
	</div>
	
	<?php
  require_once("footer.php");
  ?>



  </body>
</html>
                                                      