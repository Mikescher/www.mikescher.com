use crate::common::AdventOfCodeDay;

pub struct Day25 {
    pkey_card: u64,
    pkey_door: u64,
}

impl Day25 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/25_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        let lines = input_str
                        .lines()
                        .map(|p| String::from(p))
                        .map(|p| p.parse::<u64>().unwrap())
                        .collect::<Vec<_>>();

        Self {
            pkey_card: lines[0],
            pkey_door: lines[1],
        }
    }
}

impl Day25 {
    fn transform(subjectnumber: u64, loopcount: usize) -> u64 {
        let mut v = 1;
        for _ in 0..loopcount {
            v *= subjectnumber;
            v %= 20201227;
        }
        return v;
    }

    fn transform_back(subjectnumber: u64, pkey_dest: u64) -> usize {
        let mut v = 1;
        for lc in 1.. {
            v *= subjectnumber;
            v %= 20201227;

            if v == pkey_dest {
                return lc;
            }
        }
        panic!();
    }
}

impl AdventOfCodeDay for Day25 {

    fn task_1(&self) -> String {

        verboseln!("card public key: {}", self.pkey_card);
        verboseln!("door public key: {}", self.pkey_door);
        verboseln!();

        let loopsize_card = Self::transform_back(7, self.pkey_card);
        verboseln!("card loop size: {}", loopsize_card);
        let loopsize_door = Self::transform_back(7, self.pkey_door);
        verboseln!("door loop size: {}", loopsize_door);
        verboseln!();

        let skey_card = Self::transform(self.pkey_card, loopsize_door);
        verboseln!("card encryption key: {}", skey_card);
        let skey_door = Self::transform(self.pkey_door, loopsize_card);
        verboseln!("door encryption key: {}", skey_door);
        verboseln!();

        return skey_card.to_string().to_owned();
    }

    fn task_2(&self) -> String  {
        return "".to_owned()
    }
}