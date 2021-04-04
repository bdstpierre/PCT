<? 
session_start();
?>

<html>
<body>

<?

$valid_user = $_SESSION['valid_user'];



?>

<table>
<tr valign='top'>
<td width=150>

<?
// Fill out the navigation bar on the left side of the page
include("nav.php");
?>

</td>
<td>
<?
// Show the Schedule (if it exists)
include("displayschedule.php");
?>
</td>
</tr>
</table>

<table>
<tr valign='top'>
<td colspan = 2>
Please select one of the links below to select a different PCT:
</td>
</tr>
<tr>
<td>
Monday Night PCT
</td>
<td align='left'>
<a href="http://www.annarbortennis.com/PCT/MON/">www.annarbortennis.com/PCT/MON/</a>
</td>
</tr>

<tr>
<td>
Wednesday Night PCT
</td>
<td align='left'>
<a href="http://www.annarbortennis.com/PCT/WED/">www.annarbortennis.com/PCT/WED/</a>
</td>
</tr>

<tr>
<td>
Thursday Night PCT
</td>
<td align='left'>
<a href="http://www.annarbortennis.com/PCT/THU/">www.annarbortennis.com/PCT/THU/</a>
</td>
</tr>

</table>


</body>
</html>


