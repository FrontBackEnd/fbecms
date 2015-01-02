<?php

$chat = selectOne('p_chat_settings','1');

if(isset($chat) && !empty($chat)){
	if($chat['status'] == '1'){
		
		$out .= '<link rel="stylesheet" href="'.WEB_PAGE.'js/chat/style.css" type="text/css" />
		    
			    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
			    <script type="text/javascript" src="'.WEB_PAGE.'js/chat/chat.js"></script>
			    <script type="text/javascript" src="'.WEB_PAGE.'js/chat/script.js"></script>
			    <script type="text/javascript">
			    $(document).ready(function(){
			    
					$("#page-wrap").hide();
				
					$("#show_hide_chat").click(function(){
						$("#page-wrap").toggle(0);
						$("#show_hide_chat").toggleClass("set_on_right");
						
					});
					
					name = $( "#chat_user_email" ).val();
					
					
				});
			    </script>';			
			
		$out .= '<div id="customer_support" onload="setInterval(\'chat.update()\', 1000)">
					<span id="show_hide_chat" title="Show/Close chat" class="set_on_right"></span>
				    <div id="page-wrap">';
				
					
				if(isset($_SESSION['chat']['user_id'])){
		
		
				$out .='<h2>Customer support </h2>
				        
				        <div id="chat-wrap"><div id="chat-area"></div></div>
				        
				        <form id="send-message-area">
				        	<p>e-mail</p>
				            <textarea id="sendie" maxlength = \'100\' >enter your question</textarea>
				        </form>';
				}else{
					
				$out .='<h2>Customer support </h2>
				        
				        <div id="chat-wrap"><div id="chat-area"></div></div>
				        
				        <form id="send-message-area">
				        	<input type="email" id="chat_email" value="your email" readonly="readonly">
				        </form>';	
				}
				  	
		$out .= '	</div>
				
				</div>';    

	}
}