namespace AdventOfCode2019_22_2
{
	const DAY     = 22;
	const PROBLEM = 2;


	export async function run()
	{
		const CARDS    = 119315717514047n;
		const SHUFFLES = 101741582076661n;

		/*
			NOTES

			lcg skipping
			https://www.nayuki.io/page/fast-skipping-in-a-linear-congruential-generator

			cracking lcg
			https://tailcall.net/blog/cracking-randomness-lcgs/
		*/

		let input = await AdventOfCode.getInput(DAY);
		if (input == null) return;

		const cmds = input
			.split(new RegExp('\r?\n'))
			.filter(p => p.trim().length > 0)
			.map(p => parseLine(p));

		let states = [];
		let card_index = 0n;
		for (let i=0; i<10; i++)
		{
			states.push(card_index)
			card_index = getSourceIndex(card_index, cmds, CARDS)
		}

		AdventOfCode.outputConsole("[states]: " + states.join(" ; "));

		const [modulus, multiplier, increment] = lcg_crack(states, CARDS);

		AdventOfCode.outputConsole("[modulus]: " + modulus);
		AdventOfCode.outputConsole("[multiplier]: " + multiplier);
		AdventOfCode.outputConsole("[increment]: " + increment);

		let r = lcg_skip(multiplier, increment, modulus, 2020n, SHUFFLES);

        AdventOfCode.output(DAY, PROBLEM, r.toString());
	}

	function lcg_skip(a: bigint, b: bigint, m: bigint, x:bigint, skip: bigint): bigint
	{
		//let ainv = reciprocal_mod(a, m);

		let a1 = a - 1n;
		let ma = a1 * m;

		let y = (modpow(a, skip, ma) - 1n) / a1 * b
		let z = modpow(a, skip, m) * x

		x = (y + z) % m

		return x;
	}

	function modpow(base: bigint, exp: bigint, mod: bigint): bigint {
		base = base % mod;

		let r = 1n;
        while (exp > 0n) {
            if (base === 0n) return 0n;
            if (exp % 2n === 1n) r = (r * base) % mod;
            exp /= 2n;
            base = (base * base) % mod;
		}
		
        return r;
	}

	function reciprocal_mod(x: bigint, mod: bigint): bigint
	{
		let y = x;
		    x = mod;
		let [a, b] = [0n, 1n];
		while (y !== 0n)
		{
			let _a = b;
			let _b = (a-x) / (y * b);
			a=_a; b=_b;

			let _x = y;
			let _y = x%y;
			x=_x;y=_y;
		}
		if (x === 1n)
			return a % mod
		else
			throw ("Reciprocal does not exist")
	}

	function getSourceIndex(idxDest: bigint, cmds: Cmd[], decklength: bigint)
	{
		let idx = idxDest;
		for (let cmd of cmds.slice().reverse())
		{
			//AdventOfCode.outputConsole("[idx]: " + idx);
			if (cmd.type === CmdType.CUT)
			{
				idx = (idx + cmd.param + decklength) % decklength;
			}
			else if (cmd.type === CmdType.DEAL && cmd.param > 1n)
			{
				let f = false;
				for(let i=0n; i<cmd.param; i++)
				{
					if (((i * decklength + idx) % cmd.param) === 0n)
					{
						idx = (i * decklength + idx) / cmd.param;
						f = true;
						break;
					}
				}
				if (!f) throw "--";
			}
			else if (cmd.type === CmdType.DEAL && cmd.param === 1n)
			{
				idx = decklength - idx - 1n;
			}
			else throw cmd;
		}
		
		return idx;
	}

	function lcg_crack(states: bigint[], modulus: bigint): [bigint, bigint, bigint]
	{
		const multiplier = (states[2] - states[1]) * modinv(states[1] - states[0], modulus) % modulus
		return crack_unknown_increment(states, modulus, multiplier)
	}

	function crack_unknown_increment(states: bigint[], modulus: bigint, multiplier: bigint): [bigint, bigint, bigint]
	{
		const increment = (states[1] - states[0]*multiplier) % modulus;
		return [modulus, multiplier, increment];
	}

	function egcd(a: bigint, b: bigint): [bigint, bigint, bigint]
	{
		if (a === 0n) return [b, 0n, 1n];
		const [g, x, y] = egcd(b % a, a);
		return [g, y - (b / a) * x, x];
	}

	function modinv(b: bigint, n: bigint): bigint
	{
		const [g, x, _] = egcd(b, n)
		if (g === 1n) return x % n;
		throw "rec";
	}


	function parseLine(str: string): Cmd
	{BigInt
		const m0 = str.match(new RegExp('^cut (-?[0-9]+)$'));
		if (m0 != null) return new Cmd(CmdType.CUT, parseInt(m0![1]));

		const m1 = str.match(new RegExp('^deal into new stack$'));
		if (m1 != null) return new Cmd(CmdType.DEAL, 1);

		const m2 = str.match(new RegExp('^deal with increment ([0-9]+)$'));
		if (m2 != null) return new Cmd(CmdType.DEAL, parseInt(m2![1]));

		throw str;
	}

	enum CmdType { CUT, DEAL }

	class Cmd
	{
		type: CmdType;
		param: bigint;

		constructor(t:CmdType, n: number) { this.type=t; this.param=BigInt(n); }
	}
}
