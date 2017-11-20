The solution to this problem is similar to problem-043.
We iterate through all possible 10-digit combinations but abort most paths pretty early through a few rules.
This leads to a pretty quick execution time an a not so big program.

I even managed to squeeze all in only half the available width so the other half has space enough for an ASCII representation of the magic 5-gon ring :D.
*(You can see the result in the `problem-068 (visual)` file)*

The main piece (excluding the act of pressing everything in such a small space) was formulating the rules.
The more (an the earlier triggering) rules, the less paths we have to traverse and the faster our program gets:
*(I needed to index the elements of the ring, so I went clockwise from the outermost to the inner elements.*

The rules are:
 - `N_3 > N_0`, `N_5 > N_0`, `N_7 > N_0`, `N_9 > N_0`. We want `N_0` to be the smallest element to avoid getting the same solution multiple times, only rotated. (Also it is stated that we start counting from the smallest outer element)
 - `N_0 <= 5`, otherwise it can't be the smallest outer element
 - `N_1 <> 9`, `N_2 <> 9`, `N_4 <> 9`, `N_6 <> 9`, `N_8 <> 9`, otherwise we won't get an 16-digit number
 - `N_2+N_3+N_4 = N_0+N_1+N_2`, `N_4+N_5+N_6 = N_0+N_1+N_2`, `N_6+N_7+N_8 = N_0+N_1+N_2`, `N_8+N_9+N_1 = N_0+N_1+N_2`. Our condition for the ring to be "magic"