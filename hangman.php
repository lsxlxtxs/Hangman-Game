<?php 

	// Turn off all error reporting
	error_reporting(0);

	//start counter
	$_SESSION['wrongCounter'] = null;
	$_SESSION['gameWord'] = null;

	//start session
	session_start();
?>


<!--
Project 1 - Hangman
Laura Seletos

Test Server: http://localhost/test/hangman.php
-->

<!--start of php code-->	
<?php 		
			
			//HTML Tag
			echo '<html>';
		
			//HEADER
			echo '<head>';
			echo '<title>Hangman  (By Laura Seletos)</title>';
			echo '</head>';	
			
			$answerGameWord = '';	
			$wordForAnswer = '';
			$refreshPageMessage = '';

			//BODY
			echo '<body>';
		
			//Display Title Here
			echo '<center><br><font size="7">HANGMAN</font></p></center>';			
			
			//game is won boolean
			$gameIsWon = false;
			
			//Create variable for the path of the hangmanwords text file
			$filename = 'hangmanwords.txt';	
			
			//Set number of guesses wrong based on length of game word
			$gameWordLength = strlen($_SESSION['gameWord']);
			$maxNumberOfGuesses = 7;
			
			//Default gameWord for testing
			//$gameWord = "HANGMAN";
		
			//Set to userinput guess
			if(isset($_POST['word'])){ $userWordGuess = $_POST['word']; }
			
			//Check to see if game is over
			$gameIsOver = false;
			
			//declare to null
			$endGameMessageWordDisplay = '';
			$endGameMessage = '';
			$isCorrectMessage = '';
			
			//Is letter correct message
			$isCorrectMessage;	
			
			 //Check if letter is guessed/set
			 if(isset($_POST['letters']))
			 {
				$letterIsSet = true;
			 }
			else
			{
				$letterIsSet = false;
			}

			 //Check if letter is guessed/set
			 if(isset($_POST['guess']))
			 {
				$isGuessSet = true;
			 }
			else
			{
				$isGuessSet = false;
			}
			
			
			
			
			//Creates an array so dashes will appear where the guessed letters should go
			$letterHashes=array();
			
			// Open the file
			$fp = @fopen($filename, 'r'); 

			// Add each line to an array
			if ($fp) 
			{
			   $hangmanWordsArray = explode("\n", fread($fp, filesize($filename)));
			}
			
			
			
			if($gameIsOver == false && (!(isset($_POST['word']))) && (!(isset($_POST['letters']))) )
			{
						$numberOfHAngmanWordsInFile = count($hangmanWordsArray);
						$newWordPosition = rand(0, $numberOfHAngmanWordsInFile);
						$_SESSION['gameWord'] = $hangmanWordsArray[$newWordPosition];
						
			}

			if($_SESSION['gameWord'] == '')
			{
						$numberOfHAngmanWordsInFile = count($hangmanWordsArray);
						$newWordPosition = rand(0, $numberOfHAngmanWordsInFile);
						$_SESSION['gameWord'] = $hangmanWordsArray[$newWordPosition];
						
			}
			
if($gameIsOver == false)
{						
	
				
			
			//if either the guess letter or the guess word is set, keep the variable count
			if(isset($userWordGuess) || isset($_POST['letters']))
			{
				$_SESSION['wrongCounter'];
			}
			//if both the guess letter and the guess word is NOT set, return the variable count to 0
			else
			{
				$_SESSION['wrongCounter'] = 0;
			}
			

			//Creates a for loop to display a _ for every letter in the length of the word array
			if($isGuessSet == true)
			{
				$guess = ($_POST['guess']);
			}

			//if nothing is set for guess then display the full, empty hash line
			else
			{
				
				for($i=0; $i<$gameWordLength; $i++)
			  	{
					$letterHashes[$i] = "-";

			  	}
					//make array into string
					$guessHashString = implode('',$letterHashes);	
					$guess = $guessHashString;
			}



//------------------------------------IMAGE ARRAY-------------------------------------------			
			//Create an Array of images 
			//1-7 are levels of wrong guesses
			//Then 'youwin' & 'youlose' for conclusion of game
			$imageArray = array(
		 	0 => "images/1.png",
			1 => "images/2.png",
			2 => "images/3.png",
		 	3 => "images/4.png",
		 	4 => "images/5.png",
	 		5 => "images/6.png",
			6 => "images/7.png",
			'win' => "images/youwin.png",
	        'lose' => "images/youlose.png"
				);
			
			//DISPLAY DEFAULT IMAGE FOR HANGMAN: (will be written over as game is played)
				//call image 1 at position 0 in the image array 
				$image = $imageArray[0];			
				$imageOutput = "<center><img src='".$image."' alt='1'></center>";
				

				//	Longest English word that appears in a major dictionary (Oxford English 
				// Dictionary): Pseudopseudohypoparathyroidism (30 letters) 
				if($gameWordLength > 30)
				{
					$maxNumberOfGuesses = 10;
					$checkLengthforImg = "over 30";
				}
				if($gameWordLength < 30 && $gameWordLength > 20)
				{
					$maxNumberOfGuesses = 9;
					$checkLengthforImg = "between 30 & 20";
				}
				if($gameWordLength < 20 && $gameWordLength > 10)
				{
					$maxNumberOfGuesses = 7;
					$checkLengthforImg = "between 20 & 10";
				}
				if($gameWordLength < 10 && $gameWordLength > 0)
				{
					$maxNumberOfGuesses = 5;
					$checkLengthforImg = "between 10 & 0";
				}
				
			//Game Logic
			if(isset($userWordGuess))
			{
				// Case the user's word guess string to uppercase for comparison:
				$uppercaseGuessWord = strtoupper($userWordGuess);
				
				$gameWord = $_SESSION['gameWord'];
				
				//Check to see if the word the user guessed is correct
				if($uppercaseGuessWord == $gameWord)
				{
					
					//Change image to you win:
						//call YouWin image at position 'win' in the image array 
						$image = $imageArray['win'];			
						$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
						
						$gameIsWon = true;

						//YOU WIN THE GAME
						$endGameMessage = "YOU WIN!!!";

						//Set letter guess message to null
						$isCorrectMessage = '';
						
						$refreshPageMessage = "Refresh Page To Play Again! Keep Up The Winning Streak!";

						//Change image to you win:
						//call YouWin image at position 'win' in the image array 
						$image = $imageArray['win'];			
						$imageOutput = "<center><img src='".$image."' alt='you_win_the_game'></center>";

						// $restartGameButton = "<center>
						// <form action='' method='post' id='Restart'>
						// <input type='submit' name='restart' value='Restart Game!'>
						// 			 			<input type='hidden' name='guess' value='".$Restart."'>
						// 
						// </br>
						// 
						// 					 	</form>
						// 				  	 	</center>";
						// 
						// echo $restartGameButton;
				}
				else
				{
					//game over
					$gameIsOver=true;
				}
				
			}



//----------------------------------------------LOGIC FOR REPLACING THE MAIN IMAGE BASED ON WRONG GUESSES-----------------------------------------

	//Takes into account the different word lengths and their varying maxGuess numbers
	if($maxNumberOfGuesses == 10)
	{
		if ($_SESSION['wrongCounter'] == 1)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[1];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
		if ($_SESSION['wrongCounter'] == 3)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[2];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
		if ($_SESSION['wrongCounter'] == 5)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[3];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
		if ($_SESSION['wrongCounter'] == 6)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[4];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
		if ($_SESSION['wrongCounter'] == 8)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[5];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
		if ($_SESSION['wrongCounter'] == 9)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[6];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
	}
	if($maxNumberOfGuesses == 9)
	{
		if ($_SESSION['wrongCounter'] == 1)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[1];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
		if ($_SESSION['wrongCounter'] == 3)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[2];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
		if ($_SESSION['wrongCounter'] == 5)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[3];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
		if ($_SESSION['wrongCounter'] == 6)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[4];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
		if ($_SESSION['wrongCounter'] == 7)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[5];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
		if ($_SESSION['wrongCounter'] == 8)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[6];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
	}
	if($maxNumberOfGuesses == 7)
	{
		if ($_SESSION['wrongCounter'] == 1)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[1];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
		if ($_SESSION['wrongCounter'] == 2)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[2];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
		if ($_SESSION['wrongCounter'] == 3)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[3];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
		if ($_SESSION['wrongCounter'] == 4)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[4];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
		if ($_SESSION['wrongCounter'] == 5)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[5];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
		if ($_SESSION['wrongCounter'] == 6)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[6];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
	}
	if($maxNumberOfGuesses == 5)
	{
		if ($_SESSION['wrongCounter'] == 1)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[1];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
		if ($_SESSION['wrongCounter'] == 2)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[3];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
		if ($_SESSION['wrongCounter'] == 3)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[4];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
		if ($_SESSION['wrongCounter'] == 4)
		{
		//call YouWin image at position 'win' in the image array 
		$image = $imageArray[6];			
		$imageOutput = "<center><img src='".$image."' alt='winning'></center>";
		}
	}	
	
	
	
	//GAME OVER --- wrong guesses = max number of guesses
	if($_SESSION['wrongCounter'] == (($maxNumberOfGuesses) - 1))
	{
		//game over
		$gameIsOver=true;
	}
	
	//create an array for game word to be exploded into	
	$lettersGameWord=array();
	
	//word to explode
	$explodeGameWord = $_SESSION['gameWord'];
	
	//make game word uppercase
	$uppercaseExplodedWord = strtoupper($explodeGameWord);
	
	//break the session array of the game word into each of its characters to be stored in this array:
	$lettersGameWord = str_split($uppercaseExplodedWord);  	
	
//-------------------------------------------------------------LOGIC FOR Comparison-----------------------------------------------------
		//Push the characters from the game word to an array for comparison
		for ($i = 0; $i < $gameWordLength; $i++)
		{

		    $lettersGameWord[$i] = ($_SESSION['gameWord'][$i]);

		}

			$gameWordLength = strlen($_SESSION['gameWord']);
			

//-----------------------------------Creates an array and array printout of all the user's past guesses----------------------------------------------			

		//Code adapted from Dr. Branton's Example 4.0
			// check for letter being passed in
			if($letterIsSet == true)
			{
		        	// reconstitute names array
		        	$letterGuess=unserialize(urldecode($_POST['letters']));

		        	// add new letter if there is one
		        	if(isset($_POST['letter']))
		        	{
							//for letter guessed by user
		                	$letterGuess[]=$_POST['letter'];
							$currentLetterGuess=$_POST['letter'];						
		                	
		        	}
				}


				// show current list of names if there is one
				if(isset($letterGuess))
				{

		        	foreach($letterGuess as $letter)
		        	{
							// Case the user's word guess string to uppercase for comparison:
							$uppercaseLetter = strtoupper($letter);

		        		}
			}
			else // otherwise, set some default values
			{
					//Create an array for letters
		        	$letterGuess=array();
	

			}

	//-----------------------------------Checks if letter guesses are right or wrong----------------------------------------------			

				//create an array for the breaking up of the game word
				$breakUpWord=array();
				
				//Holds value of the the whole game word
				$explodeLettersInGameWord = $_SESSION['gameWord'];
				
				//Make uppercase
				$explodeLettersInGameWord = strtoupper($_SESSION['gameWord']);

				
				$_SESSION['gameWord'] = $explodeLettersInGameWord;
				
				//break the session array of the game word into each of its characters to be stored in this array:
				$breakUpWord = str_split($explodeLettersInGameWord);  	
				
				
				//Push the characters from the game word to an array for comparison
				for ($i = 0; $i < $gameWordLength; $i++)
				{
					//$gameWord = $_SESSION['gameWord'];
				    $breakUpWord[$i] = $_SESSION['gameWord'][$i];
				

				}		

				// check for letter being passed in
				if($letterIsSet == true)
				{

					$LettersInGameWordArray=array();
					$LettersInGameWordArray[]=$_SESSION['gameWord'];


//-----------------------------------Checks if letter guesses are right or wrong----------------------------------------------			
				
	 if (in_array($uppercaseLetter,$breakUpWord)) 
	{
			$isCorrect = true;				
	}
	else 
	{
			$isCorrect = false;		
						
	}

					if($isCorrect == true)
					{
			        	$correctletterGuess[]=$_POST['letter'];
			

						//-----------------------------------Logic for Correct Guesses-------------------------------------------------------------			

			        	foreach($correctletterGuess as $correctLetter)
			        	{
								//increment wrong guesses when wrong
								$_SESSION['wrongCounter'];

								//Print out the letters from the array so the user knows what they have 
								//already 	
								//guessed
								$isCorrectMessage = "Good Job! The letter (".$correctLetter.") you guessed is correct. Keep Guessing.";
	
			        	}
					}
					//-----------------------------------Logic for Wrong Guesses-------------------------------------------------------------			
					if($isCorrect == false)
					{
						$wrongletterGuess[]=$_POST['letter'];
						
						//increment wrong guesses when wrong
						$_SESSION['wrongCounter']++;
						
						foreach($wrongletterGuess as $wrongLetter)
			        	{
								//Creates a variable that keeps track of how many more guesses the user has left
								$guessesLeft = $maxNumberOfGuesses - $_SESSION['wrongCounter'];
								
								//Print out the letters from the array so the user knows what they have 
								//already guessed
								$isCorrectMessage = "The letter (".$wrongLetter.") you guessed is NOT correct. You now have ".$guessesLeft." more guesses left.";								
			        	}

					}
				}			


			if(isset($_POST['letter'])){ $currentLetter = $_POST['letter']; }


		
		
//-----------------------------------Creates the hash line of the hidden guess word----------------------------------------------			

				//Creates a for loop to display a _ for every letter in the length of the word array
				if($isGuessSet == true && $gameIsOver == false)
				{
					$guess = ($_POST['guess']);
				}

				//if nothing is set for guess then display the full, empty hash line
				else
				{
					for($i=0; $i<$gameWordLength; $i++)
				  	{
						$letterHashes[$i] = "-";

				  	}
						//make array into string
						$guessHashString = implode('',$letterHashes);	
						$guess = $guessHashString;
				}

//----------------------------------- LOGIC --> GuessLetter versus GameLetter ---------------------------------------------							
			if(isset($_POST['letter']))
			{
				$currentLetter = strtoupper(($_POST['letter']));
			}
			else
			{
				$currentLetter = '';
			}
			
			if(isset($_POST['letter']))
			{
				
				for($i=0; $i< $gameWordLength; $i++) 
				{
					$currentLetter = strtoupper($_POST['letter']);	

					$gameWordArray = str_split($_SESSION['gameWord']);
					
				   if($gameWordArray[$i] == $currentLetter) 
					{
						//set guess array to current letter	
						$guess[$i] = $currentLetter;
						
					}
					else
					{
						//do nothing
					}
				}
			}
			
			
//-----------------------------------Logic for If Player Guesses All Letters In Game Word-----------------------------------------------------			
//--------------------------------------------------Logic for Winning Game--------------------------------------------------------------------			

			$gameWordMain = $_SESSION['gameWord'];


			if ($guess == $gameWordMain)
			{
				$gameIsWon = true;
							
				//YOU WIN THE GAME
				$endGameMessage = "YOU WIN!!!";
				

				//Set letter guess message to null
				$isCorrectMessage = '';

				$endGameMessageWordDisplay = '';
				
				$refreshPageMessage = "Refresh Page To Play Again! Keep Up The Winning Streak!";
				
				
				//Change image to you win:
				//call YouWin image at position 'win' in the image array 
				$image = $imageArray['win'];			
				$imageOutput = "<center><img src='".$image."' alt='you_win_the_game'></center>";

				// $restartGameButton = "<center>
				// <form action='' method='post' id='Restart'>
				// <input type='submit' name='restart' value='Restart Game!'>
				// 	 			<input type='hidden' name='guess' value='".$Restart."'>
				// 
				// </br>
				// 
				// 			 	</form>
				// 		  	 	</center>";

				//echo $restartGameButton;
				
				
			}

		
//-----------------------------------Logic for Game Over-------------------------------------------------------------			

		//if they have exceeded the number of guesses they have then game is over
		
		$numberOfWrongGuesses = $_SESSION['wrongCounter'];		
		
		if($numberOfWrongGuesses > $maxNumberOfGuesses)
		{
			$gameIsOver = true;
		}
		
		
}		
		//logic for game over.
		if($gameIsOver==true)
		{
			//YOU LOSE THE GAME
			$endGameMessage = "YOU LOSE";
			
			//Set letter guess message to null
			$isCorrectMessage = '';

			$endGameMessageWordDisplay = '';
						
						
			//You guessed wrong, correct word was:
			$endGameMessageWordDisplay = "<center> Incorrect guess. Correct word was: <?php>$gameWord<?> </center>";
			
			$refreshPageMessage = "Refresh Page To Play Again! Good Luck Next Time.";
			
			//Change image to you lose:
				//call YouLose image at position 'lose' in the image array 
				$image = $imageArray['lose'];			
				$imageOutput = "<center><img src='".$image."' alt='you_lost_the_game'></center>";
				
				// $restartGameButton = "<center>
				// 			   							<form action='' method='post' id='Restart'>
				// 			
				// 						<input type='submit' name='restart' value='Restart Game!'>
				// 			   							<input type='hidden' name='guess' value='".$Restart."'>
				// 	
				// 						</br>
				// 
				// 					 </form>
				// 				  	 </center>";
								
								
				//echo $restartGameButton;
							
//-----------------------------------Logic for Restarting Game-------------------------------------------------------------			

			$Restart = $_POST['restart'];

			if(isset($Restart))
			{
					//Reset counter
					unset($_SESSION['wrongCounter']); 

					//Reset Message
					$endGameMessage = "";

					//Reset image to default:
					$image = $imageArray[0];			
					$imageOutput = "<center><img src='".$image."' alt='startGame'></center>";

					//Reset button to nothing
					$restartGameButton = ' ';
					
					$refreshPageMessage = '';

					//Reset Game Over
					$gameIsOver=false;
					
					// User inputs to null
					$userWordGuess = null;
					$_POST['word'] = null;
					$_POST['letters'] = null;
					
					$isGuessSet = false;
										
					//set restart boolean to off/false
					$Restart = null;
					
					//unset the gameword
					unset($_SESSION['gameWord']); 
											
			}
			

		}
		
		
//-----------------------------------Outputs main image----------------------------------------------			

						//Print out main image
						print($imageOutput);	

//------------------------------------GUI Printout---------------------------------------------			

						//Test output of word guessed
						echo '<center><p>';
						echo '<font size="5">';
						echo $refreshPageMessage;
						echo '</font><p>';
						echo '</center>';
						
						
						echo '<center>';
						echo '<p>';
						
						echo 'Max Number of Guesses: '.$maxNumberOfGuesses;
						echo '<p>';
						
						echo 'Number of Wrong Guesses so Far: '.$_SESSION['wrongCounter'];
						echo '<p>';
	
						echo 'Hangman Word:';
						echo '<br>';
						
						echo '<font size="30">';
						echo $guess;
						echo '</font><p>';
						

						//Display message if you win or lose
						echo '<center>';
						echo $endGameMessageWordDisplay;
						echo '<p>'.$answerGameWord;
						echo '<p>'.$endGameMessage;
						echo $isCorrectMessage;
						echo '</p></center><br>';




//-----------------------------------Creates a user input box for letter guesses----------------------------------------------			


			//Create the user input for letters:
			print("
				<center>
		    	<form action='' method='post'>
		
				<!--Create a max character input user letter guessing-->
		    	Letter Guess: <br><input type='text' name='letter' size='1' maxlength='1' value=''>
		
		    	<input type='submit' value='Go'>
			    <input type='hidden' name='letters' value='".urlencode(serialize($letterGuess))."'>
		   		<input type='hidden' name='guess' value='".$guess."'>

	        	</form> 
				</center>
					");



//-----------------------------------User Word Guess Box----------------------------------------------			
			 //Form for user to input their word guess
			print("
				<center>
		   		<form action='' method='post'>
	     		Final Word Guess:

				<br>
				<input type='text' name='word' 
				size='20' value='Word Guess'>

				<input type='submit' value='Hang'>
				</br>

				</form>
				</center>
				");



				print("<center>");
				print("Letters Guessed:");
				print("<br>");
				

						// show current list of names if there is one
						if(isset($letterGuess))
						{

				        	foreach($letterGuess as $letter)
				        	{
									// Case the user's word guess string to uppercase for comparison:
									$uppercaseLetter = strtoupper($letter);
									
									//Print out the letters from the array so the user knows what they 
									//have already guessed
				                	print($uppercaseLetter." ");
				        	}
     	
					}
					else // otherwise, set some default values
					{ 
						//Create an array for letters
			        	$letterGuess=array();


						}
				print("</center>");	
				//hidden answer:
				echo '<p>Answer: ';
				echo '<FONT COLOR="#FFFFFF">';
				echo $_SESSION['gameWord'];
				echo '</FONT>';


				
					
		?>
		
	</body>
</html>
