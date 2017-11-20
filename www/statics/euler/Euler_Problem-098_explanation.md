With this problem I tried a little bit differen methology with designing the problem.
Programs with massive (16k) input are always kind of ugly in befunge because 
all of the data must be in the program code, so I thought I can at least try a little bit around.

In this program I seperated the code, as much as I could, into independent subprograms.
All subprograms can use the [1,0]-[9,0] fields as temporary values, get their input 
from the stack and write their output also to the stack.
Then I combined them together to build the whole program.

All the subprograms are in my [BefungePrograms git repo](https://gogs.mikescher.com/gitmirror/BefungePrograms)

This resulted in more readable code and (hopefully) snippets that I can reuse in other programs.
But the code doesn't compress as good (which nobody cares about in this problem, cause of the giant input size)
and I'm sure I could optimize it a lot by using more global state and shared variables etc.

I think for my next programs I will continue as I did before and sometimes use independent code snippets
(for example for the integer-squareroot function) but for the big main program I will write it all together.

The program works like so:

1. First we calculate a "palindromic hash value" for each input word, this is a hash algorithm that 
   has no collisions as long as there are max five repeated letters in a word and has the same value for 
   palindroms.
   Practically it is a 26-digit number in base-5 where each digit denotes the amount a specific letter occurs in our word.
   We can not use a larger number than 5 for our base because then we would overflow our 64bit numbers.
   
2. Next we go through our palindromic list and search for palindroms (words with the same hash)
   With some clever sorting tricks we could do this in `log2(n)`, but I will leave this as an 
   exercise for ther reader and and implement in naively in `n^2`

3. For each word we iterate through all the squares with the correct digit count.
   This means we start with `j`, where `j = 10^(len - 1)` and wnd with `k`, where `k = (10^len) - 1`
   
4. Now (for each square) we can generate the numeric value for word B with word A + square as our map.
   When we generate our char->digit map (as an 26 element array) we also generate a digit->char map 
   to test if any digit is mapped to multiple different characters (a failure criteria)
   
5. Now we have square A and (possible) square B, with our optimized is-integer-squareroot function from problem 086 
   we test if B is a square number. And if this is the case (and B is bigger than our current candidate) we set B
   as our current result candidate
   
6. After we have done this for all pairs we can return (= print out) our current best candidate.


Used sub programs:
 - fixed_base_pow.b93
 - read_single_word.b93
 - get_palindromic_hash.b93
 - integer-squareroot-2.b93
 - is-squarenumber.b93
 - length_single_word.b93