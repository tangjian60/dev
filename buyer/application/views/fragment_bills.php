<?php foreach( $bill_records as $v ):?>
    <li class="item-content">
        <div class="item-media">
            <?php
                switch ( $v->bill_type ) {
                    case Paycore::PAY_TYPE_BJ :
                        echo '<div class="chip-media bg-black">本</div>';
                        break;
                    case Paycore::PAY_TYPE_YJ :
                        echo '<div class="chip-media bg-blue">佣</div>';
                        break;
                    case Paycore::PAY_TYPE_TG :
                        echo '<div class="chip-media bg-orange">推</div>';
                        break;
                    case Paycore::PAY_TYPE_CZ :
                        echo '<div class="chip-media bg-green">充</div>';
                        break;
                    case Paycore::PAY_TYPE_TX :
                        echo '<div class="chip-media bg-pink">提</div>';
                        break;
                    default :
                        echo '<div class="chip-media bg-red">额</div>';
                        break;
                }
            ?>
        </div>
        <div class="item-inner">
                <div class="item-title" style="font-size:16px;color:gray;">
                    <?php echo $v->memo; ?>
                    <br>
                    <span style="color:#a0a0a0;font-size:12px;"><?php echo $v->gmt_pay; ?></span>
                </div>
                <?php if ( $v->amount >= 0 ) : ?>
                    <div class="item-after" style="font-size:20px;color:green;">+&nbsp;<?php echo number_format( abs( $v->amount ), 2, '.', ',' ); ?></div>
                <?php else : ?>
                    <div class="item-after" style="font-size:20px;color:red;">-&nbsp;<?php echo number_format( abs( $v->amount ), 2, '.', ',' ); ?></div>
                <?php endif ?>
        </div>
    </li>
<?php endforeach;?>