<div class="col-md-12 col-xs-12 col-sm-12">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="font-red-sunglo"></i>
                <span class="caption-subject font-red-sunglo bold uppercase">Total Leads</span>
            </div>
            <div class="tools">
                <div style="border-radius: 10px;" class="btn-group">
                    <button id="btnDay" value="DAY" type="button" class="btn btn-default btn-time active">Daily</button>
                    <!--                    <button type="button" class="btn btn-default btn-time">Weekly</button>-->
                    <button id="btnMonth" value="MONTH" type="button" class="btn btn-default btn-time">Monthly</button>
                    <button id="btnYear" value="YEAR" type="button" class="btn btn-default btn-time">Yearly</button>
                </div>
                <a href="javascript:;" class="collapse"> </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="chart">
                <div id="wait-lead-total" style="display: block;">
                    <svg stroke="#FFB7B3"; width="50%" height="50%" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg"
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
                <canvas height="400" id="leadTotal"></canvas>
            </div>
        </div>
    </div>
</div>