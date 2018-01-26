<?php
require_once (__DIR__ . '/../internals/base.php');
require_once (__DIR__ . '/../internals/blog.php');
require_once (__DIR__ . '/../internals/euler.php');
require_once (__DIR__ . '/../extern/Parsedown.php');

$problems = Euler::listAll();

?>

<div class="boxedcontent blogcontent_euler base_markdown">

    <div style="position: relative;">
        <a href="https://github.com/Mikescher/Project-Euler_Befunge" style="position: absolute; top: 0; right: 0; border: 0;">
            <img src="/data/images/blog/github_band.png" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png">
        </a>
    </div>

	<div class="bc_header">
		<?php echo $post['date']; ?>
	</div>

	<div class="bc_data">
        <p><a href="https://projecteuler.net/problems"><img src="https://projecteuler.net/profile/Mikescher.png" /></a></p>

        <p>
            A lot of you probably know <a href="https://projecteuler.net/">Project Euler</a>.<br />
            For those who don't here a short explanation: Project Euler is a collection of mathematical/programming problems.
            Most problems consist of finding a single number and are solved by writing a program in the programming language of your choice.
        </p>
        <p>
            Most people solve these by using normal languages like C, Java, Phyton, Haskell etc.
            But you can also go a step further and try solving it with a little bit more exotic languages.
        </p>
        <p>
            So here are my solutions written in <a href="http://esolangs.org/wiki/Befunge">Befunge</a>
        </p>
        <blockquote>
            <p>
                <strong>Note:</strong><br />
                Similar to most Befunge content on this site I only used the Befunge-93 instruction-set but ignored the 80x25 size restriction.<br />
                Still I tries to keep the programs in the Befunge-93 grid size, but that wasn't possible for all. So I guess some programs are <i>technically</i> Befunge-98.
            </p>
            <p>
                Also the original <a href="https://github.com/catseye/Befunge-93/blob/master/doc/Befunge-93.markdown">befunge-93 spec</a> didn't specify the word size of the stack or the grid<br />
                So, while most programs run happily with 32bit integers some need an interpreter that supports 64bit integers for both stack and grid.
            </p>
        </blockquote>
        <p>
            I have a included javascript runner here, but for one I only enabled it for programs of reasonable sizes (a few soutions had source files in the megabyte range).<br/>
            And also it's not the fastest interpreter and some solution take quite a while to finish.<br/>
            I recommend using <a href="/programs/view/BefunUtils">BefunExec</a>. I specially made that interpreter for this project. It can run befunge code with around 6.5 MHz <i>(on my machine)</i>
        </p>

        <h1>My favorites:</h1>

        <ul>
            <li><a href="/blog/1/Project_Euler_with_Befunge/problem-101">Problem 101 - Optimum polynomial</a></li>
            <li><a href="/blog/1/Project_Euler_with_Befunge/problem-098">Problem 098 - Anagramic squares</a></li>
            <li><a href="/blog/1/Project_Euler_with_Befunge/problem-091">Problem 091 - Right triangles with integer coordinates</a></li>
            <li><a href="/blog/1/Project_Euler_with_Befunge/problem-079">Problem 079 - Passcode derivation</a></li>
            <li><a href="/blog/1/Project_Euler_with_Befunge/problem-059">Problem 059 - XOR decryption</a></li>
            <li><a href="/blog/1/Project_Euler_with_Befunge/problem-053">Problem 053 - Combinatoric selections</a></li>
            <li><a href="/blog/1/Project_Euler_with_Befunge/problem-043">Problem 043 - Sub-string divisibility</a></li>
            <li><a href="/blog/1/Project_Euler_with_Befunge/problem-017">Problem 017 - Number letter counts</a></li>
            <li><a href="/blog/1/Project_Euler_with_Befunge/problem-015">Problem 015 - Lattice paths</a></li>


        </ul>

        <h1>All solved problems</h1>
        <div class="mdtable_container">
            <table id="PEB_tableProblems" class="mdtable">
                <thead>
                    <tr>
                        <th>Number</th> <th>Title</th> <th>Time</th> <th>Size</th> <th>Solution (hover to reveal)</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                foreach ($problems as $problem)
                {
                    echo '<tr class="PEB_tablerowProblems">' . "\r\n";

                    echo '<td class="PEB_tablecellProblems PEB_TC_Number">';
                    echo '<a href="' . $problem['url'] . '">';
                    echo $problem['number'];
                    echo '</a>';
                    echo '</td>' . "\r\n";

					echo '<td class="PEB_tablecellProblems PEB_TC_Title">';
					echo '<a href="' . $problem['url'] . '">';
					echo htmlspecialchars($problem['title']);
					echo '</a>';
					echo '</td>' . "\r\n";

					echo '<td class="PEB_tablecellProblems PEB_TC_Rating">';
					echo '<a href="' . $problem['url'] . '">';
					echo '<div class="PEB_TC_Time PEB_TC_Timelevel_' . $problem['rating'] . '">';
					echo formatMilliseconds($problem['time']) . "</div></td>\r\n";
					echo '</div>';
					echo '</a>';
					echo '</td>' . "\r\n";

					echo '<td class="PEB_tablecellProblems PEB_TC_Size">';
					echo '<a href="' . $problem['url'] . '">';
					echo $problem['width'] . 'x' . $problem['height'];
					echo '<div class="PEB_TC_Size_' . ($problem['is93'] ? '93' : '98') . '">';
					echo ($problem['is93'] ? 'Bef-93' : 'Bef-98');
					echo '</div>';
					echo '</a>';
					echo '</td>' . "\r\n";

					echo '<td class="PEB_tablecellProblems PEB_TC_Value">';
					echo number_format($problem['value'], 0, null, ',');
					echo '</td>' . "\r\n";

                    echo "</tr>\r\n";
                }
                ?>
                </tbody>
            </table>
        </div>
	</div>
</div>