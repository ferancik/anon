Ahoj,<br />
zaregistroval si sa na Beh do Choča 2016. Pre dokončenie tvojej registrácie je potrebné, aby sme do 5 dní zaregistrovali tvoju platbu za:<br />
<br />
=========================================<br /><br />
<?php foreach ($submissions as $key => $sub) { ?>
    <?php foreach ($sub as $key => $row) { ?>
        <?php echo $row['label'] . ': ' . $row['value'] . '<br />'; ?>
    <?php } ?>
=========================================<br /><br />
<?php } ?>

na účet oragnizátora:<br /><br />

IBAN: SK7983300000002000641325 <br />
SWIFT/BIC: FIOZSKBAXXX<br />
Banka: Fio Banka <br />

Variabilný symbol: <?php echo $order_data['var_symbol']; ?><br />
Suma:  <?php echo $order_data['price']; ?> €<br /><br /><br />


Prosíme nevynechaj variabilný symbol ani správu pre príjemcu, vyhneme sa tak problémom s identifikáciou platieb. Ak si registroval viacej pretekárov naraz, je potrebné vykonať jednu úhradu za celú skupinu.
Po zaregistrovaní tvojej platby ti potvrdíme platnosť tvojej registrácie.<br/><br />


Ďakujeme<br /><br />


Organizátori Behu do Choča 2016<br />
<img src="<?php echo base_url("upload/event/1/email_footer.jpg"); ?>" />

