<?php
include "top.php";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// variables for the classroom purposes to help find errors.

$debug = false;

if (isset($_GET["debug"])) { // ONLY do this in a classroom environment
    $debug = true;
}

if ($debug)
    print "<p>DEBUG MODE IS ON</p>";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1b Security
//
// define security variable to be used in SECTION 2a.
$yourURL = $domain . $phpSelf;


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
//
// Initialize variables one for each form element
// in the order they appear on the form
$juiceName = "";
$email = "youremail@uvm.edu";
$link = "";
$vendor = "";
$rating = "0";
//$tags = "";
//$comment = "";


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$juiceNameERROR = false;
$emailERROR = false;
$linkERROR = false;
$vendorERROR = false;
$ratingERROR = false;
//$tagsERROR = false;
//$commentERROR = false;

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.
$errorMsg = array();

// array used to hold form values that will be written to a CSV file
$dataRecord = array();

$mailed=false; // have we mailed the information to the user?
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST["btnSubmit"])) {

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2a Security
    // 
    if (!securityCheck($path_parts, $yourURL,true)) {
        $msg = "<p>Sorry you cannot access this page. ";
        $msg.= "Security breach detected and reported</p>";
        die($msg);
    }
    
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2b Sanitize (clean) data 
    // remove any potential JavaScript or html code from users input on the
    // form. Note it is best to follow the same order as declared in section 1c.

    $juiceName = htmlentities($_POST["txtJuiceName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $juiceName;

    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $email;
	
	$link = filter_var($_POST["txtLink"], FILTER_SANITIZE_URL);
    $dataRecord[] = $link;
	
    $vendor = htmlentities($_POST["txtVendor"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $vendor;
	
	$rating = $_POST["lstRating"];
	$dataRecord[] = $rating;
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2c Validation
    //
    // Validation section. Check each value for possible errors, empty or
    // not what we expect. You will need an IF block for each element you will
    // check (see above section 1c and 1d). The if blocks should also be in the
    // order that the elements appear on your form so that the error messages
    // will be in the order they appear. errorMsg will be displayed on the form
    // see section 3b. The error flag ($emailERROR) will be used in section 3c.

    if ($juiceName == "") {
        $errorMsg[] = "Please enter the name of the juice.";
        $juiceNameERROR = true;
    } elseif (!verifyAlphaNum($juiceName)) {
        $errorMsg[] = "Your juice name appears to have extra character.";
        $juiceNameERROR = true;
    }
	
	if ($email == "") {
        $errorMsg[] = "Please enter your email address";
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = "Your email address appears to be incorrect.";
        $emailERROR = true;
    }
	
    if ($link == "") {
        $errorMsg[] = "Please enter a link for the juice.";
        $linkERROR = true;
    }
	
    if ($vendor == "") {
        $errorMsg[] = "Please enter the name of the juice.";
        $vendorERROR = true;
    } elseif (!verifyAlphaNum($vendor)) {
        $errorMsg[] = "Your juice name appears to have extra character.";
        $vendorERROR = true;
    }
	
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2d Process Form - Passed Validation
    //
    // Process for when the form passes validation (the errorMsg array is empty)
    //
    if (!$errorMsg) {
        if ($debug)
            print "<p>Form is valid</p>";

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2e Save Data
        //
        // This block saves the data to a CSV file.
		
		$query = 'INSERT INTO tblJuices (fldName,fldLink,fldVendor,fldRating) VALUES(?,?,?,?)';
		$data = array($juiceName,$link,$vendor,$rating); 
		
		$results = $thisDatabaseWriter->insert($query, $data);
        
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2f Create message
        //
        // build a message to display on the screen in section 3a and to mail
        // to the person filling out the form (section 2g).

        $message = '<h2>Your information.</h2>';

        foreach ($_POST as $key => $value) {

            $message .= "<p>";

            $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));

            foreach ($camelCase as $one) {
                $message .= $one . " ";
            }
            $message .= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
        }


        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2g Mail to user
        //
        // Process for mailing a message which contains the forms data
        // the message was built in section 2f.
        $to = $email; // the person who filled out the form
        $cc = "";
        $bcc = "";
        $from = "noreply@ejuice.com";

        // subject of mail should make sense to your form
        $todaysDate = strftime("%x");
        $subject = "Research Study: " . $todaysDate;

        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
        
    } // end form is valid
    
} // ends if form was submitted.

//#############################################################################
//
// SECTION 3 Display Form
//
?>

<article id="main">

    <?php
    //####################################
    //
    // SECTION 3a.
    //
    // 
    // 
    // 
    // If its the first time coming to the form or there are errors we are going
    // to display the form.
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
        print "<h1>Your Request has ";

        if (!$mailed) {
            print "not ";
        }

        print "been processed</h1>";

        print "<p>A copy of this message has ";
        if (!$mailed) {
            print "not ";
        }
        print "been sent</p>";
        print "<p>To: " . $email . "</p>";
        print "<p>Mail Message:</p>";

        print $message;
    } else {


        //####################################
        //
        // SECTION 3b Error Messages
        //
        // display any error messages before we print out the form

        if ($errorMsg) {
            print '<div id="errors">';
            print "<ol>\n";
            foreach ($errorMsg as $err) {
                print "<li>" . $err . "</li>\n";
            }
            print "</ol>\n";
            print '</div>';
        }


        //####################################
        //
        // SECTION 3c html Form
        //
        /* Display the HTML form. note that the action is to this same page. $phpSelf
          is defined in top.php
          NOTE the line:

          value="<?php print $email; ?>

          this makes the form sticky by displaying either the initial default value (line 35)
          or the value they typed in (line 84)

          NOTE this line:

          <?php if($emailERROR) print 'class="mistake"'; ?>

          this prints out a css class so that we can highlight the background etc. to
          make it stand out that a mistake happened here.

         */
        ?>

        <form action="<?php print $phpSelf; ?>"
              method="post"
              id="frmRegister">

            <fieldset class="wrapper">
                <legend>Add an EJuice</legend>
                <p>Add an E-Juice you've tried!</p>

                <fieldset class="wrapperTwo">
                   

                    <fieldset class="contact">
                        <legend>Juice Information</legend>
                        <label for="txtJuiceName" class="required">E-Juice Name
                            <input type="text" id="txtJuiceName" name="txtJuiceName"
                                   value="<?php print $juiceName; ?>"
                                   tabindex="100" maxlength="100" placeholder="Enter E-Juice name"
                                   <?php if ($juiceNameERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()"
                                   autofocus>
                        </label>
                        
                        <label for="txtEmail" class="required">Email
                            <input type="text" id="txtEmail" name="txtEmail"
                                   value="<?php print $email; ?>"
                                   tabindex="110" maxlength="45" placeholder="Enter a valid email address"
                                   <?php if ($emailERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()" 
                                   >
                        </label>
						
						<label for="txtLink" class="required">Link
                            <input type="text" id="txtLink" name="txtLink"
                                   value="<?php print $link; ?>"
                                   tabindex="120" maxlength="45" placeholder="Enter a valid URL"
                                   <?php if ($linkERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()" 
                                   >
                        </label>
						
						<label for="txtVendor" class="required">Vendor
                            <input type="text" id="txtVendor" name="txtVendor"
                                   value="<?php print $vendor; ?>"
                                   tabindex="130" maxlength="45" placeholder="Enter the E-Juice Vendor"
                                   <?php if ($vendorERROR) print 'class="mistake"'; ?>
                                   onfocus="this.select()" 
                                   >
                        </label>
                    </fieldset> <!-- ends contact -->
                    
                </fieldset> <!-- ends wrapper Two -->
                <fieldset class="listbox">
                        <legend>Rating</legend>
                        <select id="lstRating"
                                name="lstRating"
                                tabindex="400">
                            
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                </fieldset><!-- ends listbox -->

                <fieldset class="buttons">
                    <legend></legend>
                    <input type="submit" id="btnSubmit" name="btnSubmit" value="Register" tabindex="900" class="button">
                </fieldset> <!-- ends buttons -->
                
            </fieldset> <!-- Ends Wrapper -->
        </form>

    <?php
    } // end body submit
    ?>

</article>

<?php include "footer.php"; ?>

</body>
</html>