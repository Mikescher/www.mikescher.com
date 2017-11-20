Similar to problem 22 this is not quite befunge-friendly due to enormous input size. 
But otherwise it wasn't hard, I create for every word the word value and count the triangle numbers in it.

Two little tricks:

 - I cached the triangle numbers from 1 to 400 (biggest possible word value is 364 because the longest word is 14 letters)
 - to count the triangle numbers just add the boolean results of the `isTriangle` function. Because true is `1` and false is `0` this results equals the number of triangle numbers.
