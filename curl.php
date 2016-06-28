<body>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $.ajax({
        url:'https://graph.facebook.com/958239917605528/picture?access_token=EAAPvtnZBEA0cBAD2G4DgEFgqZCt4RqpxDStkP7RiSS4pW5NyAAzgBG9us7VZC65dbNz7WfZAQlTfE0eJwrw0CdllEQNEIr6jEA1Bo3W2lkifAZCcNYwRTv6tcx0acHlh4gAJy1jb0dC3mqoElENZCNWGvQTobCfEc6AXqDwktpPwZDZD',
        dataType:'text',
        success:function success(response)
        {
            console.log(response);     
            $('body').append(response);
        }
        
    });
});
</script>