<div id="comments" class="comments-area">
    <div id="wpdcom" class="wpdiscuz_auth wpd-default wpd-layout-1 wpd-comments-closed">
        <div id="wpd-threads" class="wpd-thread-wrapper">
            <div class="wpd-thread-list">
                <div id="wpd-comm-1_0" class="comment even thread-even depth-1 wpd-comment wpd_comment_level-1">
                    <div class="wpd-comment-wrap wpd-blog-user">
                        <div class="wpd-comment-left ">
                            <div class="wpd-avatar ">
                                <?php echo get_avatar("example@example.com", 64); ?>
                            </div>
                            <div class="wpd-comment-label" wpd-tooltip-position="right">
                                <span><?php _e("User", "wpdiscuz"); ?></span>
                            </div>
                        </div>
                        <div id="comment-1" class="wpd-comment-right">
                            <div class="wpd-comment-header">
                                <div class="wpd-comment-author ">
                                    <a href="#"><?php _e("User Name", "wpdiscuz"); ?></a>
                                </div>
                                <div class="wpd-comment-date">
                                    <?php echo $this->helper->dateDiff(date("Y-m-d H:i:s")); ?>
                                </div>
                            </div>
                            <div class="wpd-comment-text">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent id diam in nibh fringilla pharetra. Suspendisse potenti. Praesent ultrices, libero non egestas malesuada, leo nisi mattis eros, vel sollicitudin velit ex sit amet erat. Aenean vitae arcu blandit quam malesuada varius a blandit arcu. Etiam sit amet ultricies mi, at pellentesque ligula. Aliquam erat volutpat. Nunc eleifend metus nec leo aliquam, a porta justo mollis. Praesent pharetra ante ut aliquet posuere. Nam tempus massa lacus, at sollicitudin nunc faucibus eget. Nullam laoreet finibus sem eget tempus. Quisque quis placerat eros, nec molestie lectus. Vivamus vitae sapien ultricies quam egestas posuere.
                                </p>
                            </div>
                            <div class="wpd-comment-footer">
                                <div class="wpd-vote">
                                    <div class="wpd-vote-up wpd_not_clicked">
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus fa-w-14" role="img" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
                                    </div>
                                    <div class="wpd-vote-result" title="0">0</div>
                                    <div class="wpd-vote-down wpd_not_clicked">
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="minus" class="svg-inline--fa fa-minus fa-w-14" role="img" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
                                    </div>
                                </div>
                                <div class="wpd-reply-button">
                                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10 9V5l-7 7 7 7v-4.1c5 0 8.5 1.6 11 5.1-1-5-4-10-11-11z"></path><path d="M0 0h24v24H0z" fill="none"></path></svg>
                                    <span><?php _e("Reply", "wpdiscuz"); ?></span>
                                </div>
                                <div class="wpd-space"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>