<div class="tabbable">
    <ul class="nav cstm-nav-tabs wizard">
        <li class='{{"frontend.cards.step1"==request()->route()->getName()? "active" :"" }} {{in_array(request()->route()->getName(),["frontend.cards.step2","frontend.cards.step3","frontend.cards.step3a","frontend.cards.step4","frontend.cards.step5","frontend.cards.step2a","frontend.cards.step4a","frontend.cards.step4b"])? "filled active" :"" }}' id="compaign_type_action"><a href="{{ route("frontend.cards.step1")}}" data-toggle="tab" aria-expanded="true"><span class="nmbr">1</span>Step 01</a></li>
        <li class='{{"frontend.cards.step2"==request()->route()->getName()? "active" :"" }} {{in_array(request()->route()->getName(),["frontend.cards.step3","frontend.cards.step3a","frontend.cards.step4","frontend.cards.step5","frontend.cards.step2a"])? "filled active" :"" }} {{in_array(request()->route()->getName(),["frontend.cards.step2","frontend.cards.step3","frontend.cards.step3a","frontend.cards.step4","frontend.cards.step5","frontend.cards.step4a","frontend.cards.step4b"])? "filled active" :"" }}' id="account">
            
            @if(@request()->session()->has('final_array')&&@request()->session()->get('final_array')['campaign_type']=='single')
			<a href="{{ route("frontend.cards.step2a")}}" data-toggle="tab" aria-expanded="true"><span class="nmbr">2</span>Step 02</a>
			@else
			<a href="{{ route("frontend.cards.step2")}}" data-toggle="tab" aria-expanded="true"><span class="nmbr">2</span>Step 02</a>
			@endif
            
        
        </li>
        <li class='{{"frontend.cards.step3"==request()->route()->getName()? "active" :"" }} {{in_array(request()->route()->getName(),["frontend.cards.step3a","frontend.cards.step4","frontend.cards.step5","frontend.cards.step4a","frontend.cards.step4b"])? "filled active" :"" }}' id="personal"><a href="{{ route("frontend.cards.step3")}}" data-toggle="tab" aria-expanded="true"><span class="nmbr">3</span>Step 03</a></li>
        <li class='{{"frontend.cards.step3a"==request()->route()->getName()? "active" :"" }} {{in_array(request()->route()->getName(),["frontend.cards.step3a","frontend.cards.step4","frontend.cards.step5","frontend.cards.step4a","frontend.cards.step4b"])? "filled active" :"" }}' id="mapping"><a href="{{ route("frontend.cards.step3a")}}" data-toggle="tab" aria-expanded="true"><span class="nmbr">4</span>Step 04</a></li>
        <li class='{{"frontend.cards.step4"==request()->route()->getName()? "active" :"" }} {{in_array(request()->route()->getName(),["frontend.cards.step4","frontend.cards.step5","frontend.cards.step4b"])? "filled active" :"" }}' id="confirm"><a href="{{ route("frontend.cards.step4b")}}" data-toggle="tab" aria-expanded="true"><span class="nmbr">5</span>Step 05</a></li>
        <!-- <li class='{{"frontend.cards.step5"==request()->route()->getName()? "active" :"" }} {{in_array(request()->route()->getName(),["frontend.cards.step5"])? "filled" :"" }}' id="confirm"><strong>Step 6</strong></li> -->
    </ul>
</div>