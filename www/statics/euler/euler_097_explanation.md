Well this was a really easy one.
We simply multiply the number `28433` 7830457-times with two.
After each multiplication we modulo the result with 2^10 to prevent an overflow and in the end we add one.
This is really simple (the program operates completely on the stack) and works perfectly as long as our interpreter uses at least 64bit numbers.
(But this is a condition for a lot of programs I have written here)

But just for fun I have written an alternative version that uses only 32bit numbers.
You can find it on github under `Euler_Problem-097 (32bit).b93`, or here:

~~~~~~~~~~~~
"}}2( "****04003pp201p102p>04g01g2*`#v_v
Xv2*2g10**!%3*g20-2g10!-1%3*g102`2g10< 0
X>-*03g+03p01g2*3%2-!01g2+# 02g*3%v    3
Xv*2g10+*2g20g10p30+g30*+* g1022*!< @.g<
C>02g3*+01p02p            ^
~~~~~~~~~~~~