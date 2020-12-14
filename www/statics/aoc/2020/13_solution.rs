use crate::common::AdventOfCodeDay;

pub struct Day13 {
    input_time: u32,
    input_bus: Vec<Option<u32>>,
}

impl Day13 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/13_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        let t = input_str.lines().next().unwrap().parse::<u32>().unwrap();

        let b = input_str.lines().skip(1).next().unwrap().split(',').map(|p| p.parse::<u32>().ok()).collect::<Vec<Option<u32>>>();

        Self {
            input_time: t,
            input_bus: b,
        }
    }

    fn ext_euclid(a: i128, b: i128) -> (i128, i128, i128) {
        if a == 0 {
            return (b, 0, 1);
        }

        let (gcd, x1, y1) = Day13::ext_euclid(b%a, a);

        let x = y1 - (b/a) * x1;
        let y = x1;
        
        return (gcd, x, y);
    }
}

impl AdventOfCodeDay for Day13 {

    fn task_1(&self) -> String {

        let mut b = self.input_bus
                .iter()
                .flat_map(|p| p.iter())
                .map(|p| *p)
                .collect::<Vec<u32>>();
        
        b.sort_by(|a,b| (self.input_time % b).cmp(&(self.input_time % a)));

        verboseln!("{}", self.input_time);
        verboseln!("{:?}", b);
        verboseln!("{:?}", b.iter().map(|p| p - self.input_time % p).collect::<Vec<u32>>());

        return (b[0] * (b[0] - self.input_time % b[0])).to_string();
    }

    fn task_2(&self) -> String  {

        // https://en.wikipedia.org/wiki/Chinese_remainder_theorem
        // https://mathepedia.de/Chinesischer_Restsatz.html

        let formulas = self.input_bus
                           .iter()
                           .enumerate()
                           .filter(|(_,p)| p.is_some())
                           .map(|(i,p)| (i, p.unwrap()))
                           .map(|(i,p)| ((-(i as i128) % p as i128 + p as i128) as i128 % p as i128, p as i128))
                           .collect::<Vec<(i128, i128)>>();

        if is_verbose!() {
            verboseln!();
            //for (i,b) in &formulas { verboseln!("t = {: <3} | {: <3}", i, b); }
            for (i,b) in &formulas { verboseln!("t % {: <3} = {: <3}", b, i); }
            verboseln!();
        }

        let mut m = 1;
        for (_, mi) in &formulas { m *= mi; }


        let mut x = 0;
        for (ai, mi) in &formulas {
            let (gcd, ri, si) = Day13::ext_euclid(*mi as i128, m / *mi as i128);
            let ei = si * (m / *mi as i128);

            x += ai * ei;
            verbosedbg!(m, m / *mi as i128, ai, mi, gcd, ri, si, ei, x);
            verboseln!();
        }

        x = ((x % m) + m) % m;
        
        return x.to_string() //TODO
    }
}