<html>

<head>

        <script language="JavaScript" type="text/javascript" src="jsbn.js"></script>
        <script language="JavaScript" type="text/javascript" src="random.js"></script>
        <script language="JavaScript" type="text/javascript" src="hash.js"></script>
        <script language="JavaScript" type="text/javascript" src="rsa.js"></script>
        <script language="JavaScript" type="text/javascript" src="aes.js"></script>
        <script language="JavaScript" type="text/javascript" src="api.js"></script>





</head>
<body style="font-family: monospace; white-space:pre;">

    <div>
    <p>enter password:<input type="text" id ="pass" value=""/></p>
    <button onclick="genarate_public_key()">generate public key</button>
    <p>enter public key:<input type="text" id ="pbk" value=""/></p>
    <p>enter message:<input type="text" id ="message" value=""/></p>

    <p id="rsa"></p>
    <button onclick="encrypt_message()">Encrypt</button>
    <button onclick="decrypt_message()">Decrypt</button>

     <p>publick key</p>
    <p id="public_k"></p>
    <p>encrypted message</p>
    <p id="enc_m"></p>
    <p>decrypted message</p>
    <p id="dec_m"></p>
    </div>

</body>
<script>
   function genarate_public_key(){     
      
        var PassPhrase = document.getElementById("pass").value;
        var Bits = 512;

        var MattsRSAkey = cryptico.generateRSAKey(PassPhrase, Bits);
        var rsa = MattsRSAkey;
        var MattsPublicKeyString = cryptico.publicKeyString(rsa); 
        document.getElementById("rsa").innerHTML = rsa.cipher;     
        document.getElementById("public_k").innerHTML = MattsPublicKeyString;
   }

     function encrypt_message(){
        var PlainText = document.getElementById("message").value;
        var MattsPublicKeyString = document.getElementById("pbk").value;

        var EncryptionResult = cryptico.encrypt(PlainText, MattsPublicKeyString);
        document.getElementById("enc_m").innerHTML = EncryptionResult.cipher;
     }

     function decrypt_message(){
        var enc_msg = document.getElementById("message").value;
        var pass = document.getElementById("pass").value;
        var rsa = document.getElementById("rsa").innerHTML;
        var PassPhrase = pass;
        var Bits = 512;
        
        var MattsRSAkey = cryptico.generateRSAKey(PassPhrase, Bits);
        var DecryptionResult = cryptico.decrypt(enc_msg, MattsRSAkey);
        document.getElementById("dec_m").innerHTML = DecryptionResult.plaintext;
     }
</script>
</html>