This resulted in a nice program, not much data, a good amount of code and there is imho still a fair amount of possibility for more compact program flow.

Now to our algorithm:

First we remember our polynomial as an 11-element array at `[9|0]`:
~~~
[ +1; -1; +1; -1; +1; -1; +1, -1; +1; -1; +1 ]
~~~

Then we calculate the real sequence at `[9|1]`. We only need the first 11 terms, because no later than OP(11, n) we should have found the correct sequence.
~~~
seq = [1; 683; 44287; 838861; 8138021; 51828151; 247165843; 954437177; 3138105961; 9090909091; 23775972551 ]
~~~

Then we start with `k=1` and try guessing the polynomial parameters for the first k terms of our sequence.
We generate k equations for the k values we "know" of our resulting sequence, here's an example how this would look for `k=4`:
~~~
t_0 * 1 + t_1 * 1 + t_2 *  1 + t_3 *  1 = 1              (n=1)
t_0 * 1 + t_1 * 2 + t_2 *  4 + t_3 *  8 = 683            (n=2)
t_0 * 1 + t_1 * 3 + t_2 *  9 + t_3 * 27 = 44287          (n=3)
t_0 * 1 + t_1 * 4 + t_2 * 16 + t_3 * 64 = 838861         (n=4)
~~~
where we are searching (guessing) for a polynomial of the form:
~~~
t_0 * n^0 + t_1 * n^1 + t_2 * n^2 + t_3 * n^3 + ...
~~~

Represented in memory are these (up to 11) equations with up to 11 elements as an 2d array (the last element is the result):
~~~
[1; 1;  1;  1; 0; 0; 0; 0; 0; 0; 0; 1     ]
[1; 2;  4;  8; 0; 0; 0; 0; 0; 0; 0; 683   ]
[1; 3;  9; 27; 0; 0; 0; 0; 0; 0; 0; 44287 ]
[1; 4; 16; 64; 0; 0; 0; 0; 0; 0; 0; 838861]
~~~

The next step is obviously solving the equation system (its linear and we have `k` variables and `k` equations, should be possible).  
We are using the [gaussian elimination method](https://en.wikipedia.org/wiki/Gaussian_elimination).
In the first step (the *Forward Elimination*) we bring our system into the *row echelon form*.
Theoretically we only need two operations for this:
"Multiply an equation by a factor" and "Subtract one equation from another".
But the values of our variables can grow in the steps of our algorithm quite large, so after every operation we "simplify" all modified equations.
This means we calculate the [GCD](https://en.wikipedia.org/wiki/Greatest_common_divisor) of all the variables, and the result of an equation and then multiply the equation by `1/gcd`.
This way we have again the smallest representation of this equation.
After all this our equation system should look like this:
~~~
[1; 1; 1; 1; 0; 0; 0; 0; 0; 0; 0; 1     ]
[0; 1; 3; 7; 0; 0; 0; 0; 0; 0; 0; 682   ]
[0; 0; 1; 6; 0; 0; 0; 0; 0; 0; 0; 21461 ]
[0; 0; 0; 1; 0; 0; 0; 0; 0; 0; 0; 118008]
~~~
Next we do the back substitution step, which is also just a bunch of subtracting one equation from another. The result should look like this:
~~~
[1; 0; 0; 0; 0; 0; 0; 0; 0; 0; 0; -665807 ]
[0; 1; 0; 0; 0; 0; 0; 0; 0; 0; 0; +1234387]
[0; 0; 1; 0; 0; 0; 0; 0; 0; 0; 0; -686587 ]
[0; 0; 0; 1; 0; 0; 0; 0; 0; 0; 0; +118008 ]
~~~
In the actual implementation it can happen here that some rows have `-1` as their value at `eq[i;i]`.
To fix this we simply multiply all equations with `eq[i;i]` in the last step.

From the solved equation system we can now read our current best guesses for `t_0..t_11`:
~~~
[ -665807; +1234387; -686587; +118008; 0; 0; 0; 0; 0; 0; 0 ]
~~~
and calculate our (best guess) for the sequence:  
(again we only need the first 11 terms.
After them we either have found a FIT, or found the correct values for `t_0..t_11`)
~~~
[ 1; 683; 44287; 838861; 3092453; 7513111; 14808883; 25687817; 40857961; 61027363; 86904071 ]
~~~
Next we compare this sequence with the correct sequence (that we calculated at the beginning).
In this case we find the FIT at term 5 (`3092453`).
That means we remember its value an try the whole process again with `k=k+1`.

If all 11 terms were equal, we would have found the correct polynomial.
We then output the sum of all previous FIT values and terminate our program.

If you're running this program in a good visual interpreter (for example [BefunExec](https://www.mikescher.com/programs/view/BefunUtils)) be sure to look at the top part were the equations are stored. 
It's interesting seeing the gaussian elimination algorithm live in action.
