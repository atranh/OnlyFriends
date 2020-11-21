<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Direct Messages</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="chat.css">
    <?php
    $username = $_SESSION["username"];
    $db = new mysqli("localhost", "id15345354_memberdb","CPS530Group123-","id15345354_members");
    if ($db -> connect_error) {
        echo ("Failed to connect to MySQL: " . $db -> connect_error);
        exit();
    }

    $prompt = "SELECT * FROM Login WHERE Username LIKE '$username'";
    $data = $db->query($prompt);
    $row = mysqli_fetch_row($data);
    $FirstName = $row[4];
    $LastName =$row[5];
    $FullName = $FirstName . " " . $LastName;
 
    ?>
    <script>
        var from=null, receiver=null, start = 0, url = "https://onlyfriendspage.000webhostapp.com/dm/chat.php";
        //var chatswap = false;
        $(document).ready(function(){
            $('select').on('change', function() {
                //$("#messages").empty();
                from = "<?php echo $username ?>";
                receiver = this.value;
                //chatswap=true;
                //load() UNCOMMENT IF WANT INSTANT MESSAGING ON PAID SERVERS
                //COMMENT BELOW THIS OUT IF WANT INSTANT MESSAGING
                setInterval(function () {
                    load();
                }, 1500); //1.5 seconds
                //}, 1000000); //17 minutes
                //}, 8000000 ); //3 hours
                //COMMENT ABOVE THIS OUT IF WANT INSTANT MESSAGING (It'll max out a free database quick tho)
                
                //This is just to send messages into chat, not actually print anything
                $('form').submit(function(e){
                    //Ajax
                    //https://www.w3schools.com/jquery/jquery_ajax_get_post.asp
                    $.post(url, {message: $('#message').val(),
                    sender: from,
                    recipient: receiver 
                    });
                    $('#message').val("")
                    return false;
                }) 
            });
        });
        
        //Load the messages
        function load(){
            $.get(url + '?start=' +start, function(result){
                if(result.items){
                    //result.items.forEach(item =>{
                    //    start = item.id;
                    //    $('#messages').append(renderMessage(item));
                    //});
                    for (let item of result.items) {
                        ///This select shit here is the source of spaghetti, but idk how to replace it lmao
                        //Try using the messages.empty above and comment this one below out, and see how it works
                        $('select').on('change', function() {
                            $("#messages").empty();
                            //if (chatswap==true){
                            //    chatswap=false;
                                //is it possible the bug is caused because when u press
                                //a button, it goes here and then goes to the code below as well?
                                //try moving this to its own function or below the  shit below
                                //https://jsfiddle.net/phpdeveloperrahul/CAKG4/
                                //also see what happens when u set start=1 here
                                //also test using alerts and see how the program itself works and if
                                //its infinitely calling from sql. like lets say its read the first
                                //30 msgs from database already, does it keep looping 1-30 or goes 31+
                                //could duplication glitch be because the id(start) goes to like 6,
                                //but theres only 3 things actually being printed?
                                //unlikely because i think program actually goes through everything
                                //and it just checks using if statements if the sender and recipient
                                //matches up and displays that.
                                start=0;         
                                console.log("test");
                            //}
                        });
                        //alert(start);
                        start+=1;
                        //start = item.id;
                        $('#messages').append(renderMessage(item));
                    }
                    $('#messages').animate({scrollTop: $('#messages')[0].scrollHeight});
                };
                //load(); UNCOMMENT IF WANT INSTANT MESSAGING ON PAID SERVERS NOT RECOMMENDED
            });
        }

        function renderMessage(item){
            let time = new Date(item.created);
            time.setHours(time.getHours()-5);
            time = `${time.getHours()}:${time.getMinutes() < 10? '0' :''}${time.getMinutes()}`;
                //NEED TO EDIT THIS LINE SO NOT HARD CODED, EXTRACT THE RECIPIENT FROM FRIEND LIST
                if ((item.recipient == receiver && item.sender == "<?php echo $username ?>") || (item.recipient == "<?php echo $username ?>" && item.sender == receiver))
                {
                    if (item.sender == "<?php echo $username ?>")
                    {
                        return `<div class="msg msguser"><p>${item.sender}</p>${item.message} <span>${time}</span></div>`;
                    }
                    else
                    {
                        return `<div class="msg"><p>${item.sender}</p>${item.message} <span>${time}</span></div>`;
                    }
                }
        }
    </script>

</head>
<body>
    <div id="messages"></div>
    <form>
        <input type="text" id="message" autocomplete="off" autofocus placeholder="Type message...">
        <input type="submit" value="Send">
    </form>
    <select>
    <option disabled selected value>Talk</option>
    <option value="asuna">asuna</option>
    <option value="Yukino">Yukino</option>
    <option value="misaka">misaka</option>
    </select>
</body>
</html>
