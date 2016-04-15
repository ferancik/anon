<?php if ($breadcrumb) { ?>
    <div class="page-bar hidden-xs hidden-phone">
        <ul class="page-breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="<?php echo site_url(); ?>">Úvod</a>
                <i class="fa fa-angle-right"></i>
            </li>



            <?php for ($i = 1; $i < count($breadcrumb) - 1; $i++) { ?>
                <li>
                    <a itemscope itemtype="http://data-vocabulary.org/Breadcrumb" itemprop="url"  href="<?php echo $breadcrumb[$i]['href']; ?>">
                        <span itemprop="title">
                            <?php echo $breadcrumb[$i]['text']; ?>
                        </span>
                    </a>
                    <i class="fa fa-angle-right"></i>
                </li>
            <?php } ?>
            <li><?php echo $breadcrumb[count($breadcrumb) - 1]['text']; ?></li>
        </ul>
    </div>
<?php } ?>

