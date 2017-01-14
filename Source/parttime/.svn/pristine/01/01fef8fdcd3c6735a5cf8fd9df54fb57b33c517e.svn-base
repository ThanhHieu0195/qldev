<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!--<p>
    <label>Tháng</label>
    <select name="month">
        <?/*
        for ($i = 1; $i <= 12; $i++) {
            if ($i == $_REQUEST["month"])
                echo "<option value='".$i."' selected>".$i."</option>";
            else
                echo "<option value='".$i."'>".$i."</option>";
        }*/
        ?>
    </select>
</p>-->
<p>
    <label>Năm</label>
    <select name="year">
        <?php
        date_default_timezone_set('UTC');
        $year = date("Y");
        for ($i = $year; $i >= $year - 10; $i--) {
            if ($i == $_REQUEST["year"])
                echo "<option value='$i' selected>$i</option>";
            else
                echo "<option value='$i'>$i</option>";
        }
        ?>
    </select>
    <input class="button" name="view" type="submit" value="Thống kê" />
</p>
