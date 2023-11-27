<div class="col-md-12 col-xs-12 col-sm-12">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="font-red-sunglo"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">CHANNELS</span>
            </div>
            <div class="tools">
                <a href="javascript:;" class="collapse"> </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="chart-lead-channel-lead col-md-12">
                    <div id="wait-lead-ChannelLeadIn" style="display: block;">
                        <svg stroke="#FFB7B3" ; width="50%" height="50%" viewBox="0 0 38 38"
                             xmlns="http://www.w3.org/2000/svg"
                             style="position:absolute;top: 50%;left: 50%; transform: translate(-50%, -50%)">
                            <g fill="none" fill-rule="evenodd">
                                <g transform="translate(1 1)" stroke-width="2">
                                    <circle stroke-opacity=".5" cx="18" cy="18" r="18"/>
                                    <path d="M36 18c0-9.94-8.06-18-18-18">
                                        <animateTransform
                                                attributeName="transform"
                                                type="rotate"
                                                from="0 18 18"
                                                to="360 18 18"
                                                dur="1s"
                                                repeatCount="indefinite"></animateTransform>
                                    </path>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <canvas height="300" id="chartChannel"></canvas>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <form>
                            <input type="hidden" value="1" id="pageChannelLead" name="page">
                        </form>
                        <button id="btn-show-more-channel-lead" style="background: #FF6E66;float: right;"
                                class="btn btn-md">Show More
                        </button>
                        <button id="btn-show-less-channel-lead"
                                style="background: #9B9B9B;float: right;display: none;"
                                class="btn btn-md">Show Less
                        </button>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>