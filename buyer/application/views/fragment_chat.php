<div class="list-block" style="margin-top: 0;">
    <ul>
        <?php foreach ($notice_list as $notice): ?>
            <li>
                <a href="<?php echo base_url('pages/notice/' . $notice->id); ?>" class="item-content item-link">
                    <div class="item-media"><img class="setting-icon" src="<?php echo CDN_BINARY_URL; ?>/gonggao.png"></div>
                    <div class="item-inner">
                        <div class="item-title" style="font-weight: bold;"><?php echo $notice->title; ?></div>
                        <div class="item-title"><?php echo $notice->gmt_create; ?></div>
                        <div class="item-after"></div>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
        <?php foreach ($messages as $message): ?>
            <li>
                <a href="<?php echo base_url('pages/message/' . $message->id); ?>" class="item-content item-link">
                    <div class="item-media">
                        <?php if ($message->read_status == 1 ): ?>
                            <img class="setting-icon" src="<?php echo CDN_BINARY_URL; ?>/news.png">
                        <?php else: ?>
                            <img class="setting-icon" src="<?php echo CDN_BINARY_URL; ?>/news-active.png">
                        <?php endif; ?>
                    </div>
                    <div class="item-inner">
                        <div class="item-title" style="font-weight: bold;"><?php echo $message->title; ?></div>
                        <div class="item-title"><?php echo $message->gmt_create; ?></div>
                        <div class="item-after"></div>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>

    </ul>
</div>
<!-- 
<div class="messages" style="min-width: 85%;">
    <?php foreach( $messages as $value ) : ?>
    <div class="messages-date">
        <span><?php echo $value->gmt_create; ?></span>
    </div>
    <div class="message message-with-avatar message-received" style="position:relative;max-width: 90%">
        <div class="message-text-k" style="margin-left:20px;border-radius:18px;color:white;background-color:#00d449;font-size:16px;">
            <?php echo $value->content; ?>
        </div>
    </div>
    <?php endforeach;?>
</div> -->
<div style="height:100px;"></div>