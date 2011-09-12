<?
 $WHERE = '1';
 $GROUP = 'GROUP BY KillerID';
?>
<div class="body_ministats">
<table class="tablesorter" cellspacing="0" cellpadding="2" style="margin-top:12px;" id="dogtags">
     <thead>
       <td class="head" colspan="7" >Dogtags ==|====></td>
      <tr> 
			    <th width="263px">Killer</th>
				    <th width="263px">Victim</th>
				   <th width="263px">Dogtags</th>
			</tr>
       </thead> 
        <tbody> 
        	<?php

	$con = mysql_pconnect("web2.cmdcentral.co.za", "root", "ryvenapa121");
	$db = mysql_select_db("bfbc2");
 
          
   $sSql = "SELECT * 
          FROM (Select 
           a.*,
           b.PlayerID,
           b.SoldierName
         FROM
           tbl_dogtags a
         Left JOIN 
           tbl_playerdata b ON a.KillerID = b.PlayerID
          WHERE {$WHERE}
        ORDER BY 
          Count DESC) as Count
          	{$GROUP} Order by Count DESC";
          
        $result = mysql_query($sSql);
       while($row = mysql_fetch_assoc($result)){
      
       $ID = $row['VictimID'];
       $Count = $row['Count'];
     
          $sSqlN = "SELECT SoldierName FROM tbl_playerdata WHERE PlayerID = {$ID}";
         $resultN = mysql_query($sSqlN);  
       $rowN = mysql_fetch_assoc($resultN);
      	 $VictimN = $rowN['SoldierName'];

      
   ?>
      <tr class="hov">	
         <td class="result"><?php echo htmlspecialchars($row['SoldierName']); ?></td>
        	<td class="result"><?php echo htmlspecialchars($VictimN); ?></td>
         <td class="result"><?php echo $Count; ?>&nbsp;&nbsp;<img src="/playerstats/img/sig/dogt.png" border="0" width="17px"/></td>
        <tr>
   <?php    
     	}
   ?>
      </table>
	  <br /> 
</tbody>
</div>
<script type="text/javascript">
        $(function() {
                $("#dogtags").tablesorter({sortList:[[2,1]], widgets: ['zebra']});
        });
</script>

