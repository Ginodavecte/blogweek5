<?php
//redirect functie
function redirect_to($new_location){
    header("Location: " . $new_location);
    exit;
}

function fill_category($connection)
{
    $output = '';
    $sql = "SELECT * FROM category ORDER BY id";
    $result = mysqli_query($connection, $sql);
    while($row = mysqli_fetch_array($result))
    {
        $output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
    }
    return $output;
}

function makepassword($length)
{
    $validCharacters = "ABCDEFGHIJKLMNPQRSTUXYVWZ123456789";
    $validCharNumber = strlen($validCharacters);
    $result ="";
    for ($i = 0; $i < $length; $i++)
    {
        $index = mt_rand(0, $validCharNumber - 1);
        $result .= $validCharacters[$index];
    }
    return $result;
}

function selectMonth(){
  ?><div >
        <option value='1'>Janauri</option>
        <option value='2'>Februari</option>
        <option value='3'>Maart</option>
        <option value='4'>April</option>
        <option value='5'>Mei</option>
        <option value='6'>Juni</option>
        <option value='7'>Juli</option>
        <option value='8'>Augustus</option>
        <option value='9'>September</option>
        <option value='10'>October</option>
        <option value='11'>November</option>
        <option value='12'>December</option>
</div>
    <?php
}