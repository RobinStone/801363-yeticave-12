<?php
$ask = q("
SELECT rates.*, users.id AS ID_USER, lotes.id AS ID_LOTES, lotes.name, lotes.cat, lotes.img, lotes.text, lotes.date_end FROM `rates`
LEFT JOIN `users` ON rates.id_user = users.id
LEFT JOIN `lotes` ON rates.id_lot = lotes.id
WHERE rates.id_user = ".(int)$_SESSION['user']['id']." ORDER BY lotes.date_end ASC
");

if($ask->num_rows) {
    while($row = $ask->fetch_assoc()) {
        $arr[] = $row;
    }
}
?>

<main>
    <nav class="nav">
        <?=include_template('listCats.php', ['cats'=>$cats])?>
    </nav>
    <section class="rates container">
        <h2>Мои ставки</h2>
        <?php if(isset($arr)) { ?>
        <table class="rates__list">
            <?php foreach($arr as $v) {
                $end_time = format_time_lost($v['date_end']);
                $end_time[0] = str_pad($end_time[0], 2, "0", STR_PAD_LEFT);
                $end_time[1] = str_pad($end_time[1], 2, "0", STR_PAD_LEFT);
                ?>
            <tr class="rates__item">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="../<?=$v['img']?>" width="54" height="40" alt="<?=$v['name']?>">
                    </div>
                    <h3 class="rates__title"><a href="/lot/<?=(int)$v['ID_LOTES']?>"><?=$v['name']?></a></h3>
                </td>
                <td class="rates__category">
                    Доски и лыжи
                </td>
                <td class="rates__timer">
                    <div class="timer">
                        <?php
                        if((int)$end_time[0] < 24) {
                            echo $end_time[0].':'.$end_time[1];
                        } else {
                            echo floor($end_time[0]/24).' сут.';
                        }
                        ?>
                    </div>
                </td>
                <td class="rates__price">
                    <?=format_cost($v['lot_cost'])?>
                </td>
                <td class="rates__time">
                    <?=format_old_time($v['datatime'])?>
                </td>
            </tr>
            <?php } ?>
        </table>
        <?php } else { echo '<p style="font-size: 1.5em; color: red;">У Вас пока нет ставок...</p>'; } ?>
    </section>
</main>
