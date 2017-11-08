This problem is very similar to the previous one. We iterate through all Pentagonal numbers (starting at P_144) and test the numbers if they are hexagonal.

The test for hexagonal numbers is the same as in Problem-44, but we have to expand the iSquare function for int64 numbers ([20] is now 2^60 instead of 2^30).

The major trick is that we only need to test for the hexagonal property. Because all hexagonal numbers are also Triangle numbers. 
Think about it, a Hexagon has six edges and a Triangle three, so every Hexagonal contains two triangles.

`H_{n} == T_{2*n}`