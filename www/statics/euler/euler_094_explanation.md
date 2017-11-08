Nothing much to say about this one, we play a bit with the triangle formulas until we reach something that looks like a [Pell equation](https://en.wikipedia.org/wiki/Pell%27s_equation).
My approach is basically the same as the one on [mathblog.dk](http://www.mathblog.dk/project-euler-94-almost-equilateral-triangles/), but he explains it better.
(And I improved my approach a bit after I read his article, his math skills are pretty good :D).

The code is in a way interesting because it only has a single conditional operator.
I could remove two conditional by multiplying the increment with the normalized condition (`0`|`1`).
This way `if (condition) { x += increment; }` becomes ` x +=  (int)(condition) * increment`, 
which is a neat way to safe a bit of space in our program (and the resulting 40x5 code is pretty compact)