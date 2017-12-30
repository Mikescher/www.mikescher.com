![sudoku debug](/data/blog/SudokuSolver/sudoku.png)

Because of [this project euler puzzle](https://www.mikescher.com/blog/1/Project_Euler_with_Befunge/problem-096) I spend the last few days implementing a sudoku solver in befunge-93 (as always I ignored the 80x25 size restriction because otherwise befunge-93 would be not turing-complete and I'm pretty sure this problem impossible).

There are two general types of sudoku problems, the one were in every step there is an cell with an obvious solution (these are the easy ones) and the ones were you have to guess sometimes (or deploy more complex strategies).
My solver is universal and can solve both ones. If there are no obvious cells it tries to make an smart guess and if the guess was wrong we backtrack and try with the next number.

Below i try to describe my general approach and a few caveats I stumbled across. You can look at the full up-to-date source code on [github](https://github.com/Mikescher/BefungePrograms).

~~~
v XX    ###########  ###########  #############################        #############################
 C    C #36  2  89#  #         #  #                           #        #                           #
 PPPPP  #   361   #  #         #  #                           #        #                           #
 XXX    #         #  #         #  #                           #        #                           #
 LLLLLL #8 3   6 2#  #         #  #                           #        #                           #
 PMMMM  #4  6 3  7#  #         #  #         ##########        #        #                           #
 MM MMM #6 7   1 8#  #         #  #     ##################    #        #                           #
 XXX XX #         #  #         #  #     ##################    #        #                           #
        #   418   #  #         #  #   ####################### #        #                           #
        #97  3  14#  #         #  #   ####################### #        #          #######          #
        ###########  ###########  # ####################      #        #       ############        #
                                  # ####################      #        #      ###############      #
>           492*+11p9:*:9*61p>1-v # ################          #        #     #################     #
   >9+\9/1+p:0\:9%11g+\9/1+p:|    # ############              #        #     #################     #
   ^%9:\+*86%+88 g+1/9\+9%9::$#:< # ############              #        #     ######## ########     #
v1/*93\+*75%*93:\0:-1<g16p021<    # ################          #        #     #################     #
>+p:0\:39*%89*+\39*/#| 1#:+# p# < # ####################      #        #     #################     #
v               p030$<>p152p::9%v #   ####################### #        #      ###############      #
>9:*>1-:9/32p:9%22p212^vg+1/9\+9< #   ####################### #        #       ############        #
v10  $<                >68*-:42pv #   ####################### #        #          #######          #
4   ^_^#:                    <v!< #     ##################    #        #                           #
p         @    >1-:9%24p:9/3v^_ v #         ##########        #        #                           #
>30g9:*-!#^_9:*^            4$    #         ##########        #        #                           #
 v0p450_v#!-*86 g+g431+g429p<     #                           #        #                           #
    >   >    :#^_$14g#v_015p   v  #                           #        #                           #
^                 p410<           #                           #        #                           #
p6   v:p45+1g44             <     #                           #        #                           #
4>4p9 >1-:44p57*24g3*44g3%+v      #                           #        #                           #
1   #>|:_v#g++/3g44*3g431+ <      #############################        #############################
0     $  >64g1+64p          ^|  #
    ^             <         $<v>#              #<                     >025p035p045p9:*:*55p9:*>1-: 9%16p:9/26p916gv
      >64g:!#v_1-#^_14g1+14pv#> >42g68*+22g9+3 v                      ^      < v _v#!g54    $_^#!:<_v#<-*86g+g621+<
  v        $$<vg43p22g42p211<:  v9p03+1g03p+1g2<^             p25g02<  v02:+1 g 02<vg65$_ v0p650p640< ^1         <<
              >32p54g42p20g5v-  >1-:13p"X"57*22g3*13g3%++132g3*13g3v   >p11g2 5 g+v!    ! >1+:66p57*16g3*66g1-3%v
 >>01-::17p27p37p9:*v_$ 9v  21   vg++/3g31*3g231++%3g31*3g22*98p++/< vp210p+g 5 31<5>pv  < _v#g++/3-1g66*3g621++<
   v94p76/9:p75%9:-1<^:<<:  p  v _52g89*22g3*13g3%v                  >25g22p3 5 gv 56 : -   >56g1+56p4 v
   >2*+57g+167g+g20g-  |p:  > ^:|:p++/3g31*3g231++<                 ^ p24g54p 2 3< g4 >9^|+!`g51g66!!g6<          p
        v*86g+g761+g759<7*      >$9>1-:23p"X"57*23g3*42g1-3%++132g3*42g1-3v        5^g66 <>                      ^5
        >-17p57g27 p67g3^*      #   vg++/3-1g24*3g231++%3-1g24*3g32*98p++/<        >6g`!+#^_16g25p26g35p46g45p56g5^
   v*98p76/*93:p75%*93:-1< _$ v>^v  _52g89*23g3*42g1-3%v v >#                ^#<
   >57g+167g+g20g-!    #v_:^< 2  >:|:p++/3-1g24*3g231++<
   v75*750p+g761+g75*980<  :: 0v19$<>p"X"57*22g3*42g1-3%+ + 133g3*42g1-3/++v
    >167g3/+g         68*-!|  g>-:33^vg++/3-1g24*3g331++% 3 -1g24*3g22*98p <
    ^+/3g759<v61+/ 3g759*86<  1^1 < v_52g89*22g3*42g1-3%v
   >g+167g+p^>7g3/+p30g1-30p^ -   |:< p++/3-1g24*3g331++<
   vp51g71p+g731+g72+*2940p02 <   >$9>1-::3%23p3/33p"X"57 * 22g3/3*23g+3*42g1-3%++132g3/3*33g+3*42gv
 ^ >#             #<v  >     ^ v># #<^ vg++/3-1g24*3+g33* 3 /3g231++%3-1g24*3+g32*3/3g22*98p++/3-1 <
^                    $_^#!:g21$<   v  :_52g89*22g3/3*23g+ 3 *42g1-3%v
                   ^>#       #<v^  _^#: p++/3-1g24*3+g33* 3 /3g231++<
                              ^>#                       #< ^
~~~
(To test the code I recommend my [befunge interpreter BefunExec](https://github.com/Mikescher/BefunExec), simply input your sudoku in the top-left rectangle and run the program)


Introduction
============

First we need a data structure for the current state, we simply take a `9x9` array
(a sudoku puzzle contains nine `areas` with nine `fields` each = 9x9 fields in total).
A zero in a field means `unkown` and the numbers one to nine are valid values.
Because I wanted the program too look a little bit aesthetically pleasing
I used ASCII-numbers instead of raw binary values ;).
This array is from now on called `grid`.

Next we need a place to remember which values are possible for a specific array.
Therefore we use a 3x3 array for each field which fields represent the 
nine possible numbers (`1..9`).
This data is structured into a `27x27` field (`= (9*3)x(9*3)`).
This array is from now on called `pspace`

Set Up
======

Initially we take the known values from our input and write them to the `grid` array.
For each value we also have to update the `pspace`.
If we set a value in the grid to `v` at position `[x|y]` we have to 
 - set the `pspace[dx, dy, v]` of all fields `dx|dy` in the same area to true
 - set the `pspace[dx, dy, v]` of all fields `dx|dy` in the same row to true
 - set the `pspace[dx, dy, v]` of all fields `dx|dy` in the same column to true

We can calculate the position in the `pspace` are like this: 
~~~
px = (x*3) + ((v - 1)%3)
py = (y*3) + ((v - 1)/3)
~~~

Solving simple puzzles
======================

After we initialized the array we scan all fields and search 
for pspace configurations where all numbers are set to `1` except one.
For these it is unambiguous which value it has (the one where `pspace== `)
Then we set this value in the `grid` array (and - again - update the `pspace`).
This step is repeated until the whole puzzle is solved. 
(We need a isSolved function for this, but it only needs to check
for zeroes in the `grid` array).

Solving the rest
================

The described approach works great for the first puzzle, but as soon
as we try the second one we stumble upon a problem.
There a situation where not a single field has a obvious solution and we
need to "guess" a value to continue. (And then backtrack if the guess 
was wrong and try the next possibility).

For this we introduce two new arrays into our memory model `rstack[27,27]` and `rlatter[9,9]`.
And we keep track of a global value that we call `recursionDepth` (initially `1`).
Every time we set a value in our `pspace` we write into 
the corresponding `rstack` field our current `recursionDepth`.

Now as soon as we encounter a dead end (all fields are either solved or have multiple possible solutions)
we go one step down.
First we increase the `recursionDepth` by 1.
Then we take the easiest field (field with the least possible values) and set it to the lowest possible value.
We also set the corresponding field in `rlatter` to the current `recursionDepth`.

Now we continue with our algorithm as before until one of three things happen:
1. We solve all fields. Then we found the solution and our program terminates.
2. We have again the situation with no unambiguous fields, then we do the whole thing again and increase the `recursionDepth` again.
3. We end up with a field which `pspace` contains only ones (meaning there is no possible value for this field).

In case 3 it is obvious that we must have guessed wrong in the past.
So first we undo the last recursion step.
We iterate through the whole `rstack` and everywhere where the value equals our current `recursionDepth` 
we set the corr corresponding `pspace` value to zero.
If the value in `grid` at this position is not zero we set it to zero
(because we must have set it in this recursion level and now we can't be sure if its correct).

Then we decrease the `recursionDepth`  by one again.

Before we reseted all the values we looked into our `rlatter` to get the grid position that 
was guessed when we entered this `recursionDepth`
(This is simply done by searching the field with the value `recursionDepth`).
Now we "guess" the next possible value for this field and increase the recursion 
depth once again (and continue with our normal operations).

If we can't find another value for this field (means we tried all available and all where wrong)
we simply go one step further up (decrease the `recursionDepth` again, complete with undoing all changes etc)
and take the next value of this guess.

This algorithms runs until we either find a solution or there is no solution
(in this case we would after a while try to undo the `recursionDepth` 1 and go into `recursionDepth`  ).

Design decisions
================

This algorithm is definitely not the best in a normal C-like language but it has a its pros in befunge.
First we have realized recursion-like behavior without a stack or an data structure with unknown size
(which would happen if we simply wrote the "stack" to our befunge-grid).
It is true that we could possibly be used the normal befunge-stack for our recursion-stack.
But we do enough stuff already on the stack that this would result in a much more complex program 
(and at times a really big stack).
My solution with an additional grid (`rstack`) is imho quite elegant and has a fixed size from the beginning on.

I didn't optimize this program as much as possible. Not only because its quite a big program but also because it
doesn't need to be terribly fast and because I wanted to keep the interesting 
look with thee four array fields while solving.

In the end this is not my fastest solution but a complete sudoku solver in befunge is in my opinion quite cool.

As with most bigger befunge programs I made a reference Implementation in C# (with LinqPad),
if someone wants to better understand this algorithm, perhaps also look at this code :D

Befunge Modules
===============

In my reference C# implementation I have a few methods that get called multiple times from different origins.
But (through carefully writing the code) there is never a case where the same method is multiple times on the call stack
(so the program is not recursive, even though the algorithm is).
I didn't want to duplicate code, especially not some of the bigger methods so I used a special cell to remember the "return value".
After the method has finished it then can decide on its own where the PC has to flow to resume the program.

One example is the method `SetValueAndHints`. This method can get called from three different positions:
 - In the initialization phase
 - When `RecursionStepDown` fails and we discard the current guess
 - When a cell contains invalid data and we discard the current guess
The return address is part of the "parameter-package" that gets written every time `SetValueAndHints` is called
(The package contains `returnAddr`, `cx`, `cy`, `value`, `recDepth`).
Because *(see above)* the method is never two times on our theoretical "call stack" we don't have problems with someone overriding
values there while they are still used.

For the method `RecursionStepDown` we got lucky. Even though the method is called from two different positions we could rearrange
our algorithm in a way that the return address of both calls is the same, 
that means we don't need a return address (but still a parameter package).
The same is true for `RecursionStepUp`, it is called from two sources but both time it returns into a call of `RecursionStepDown`.

