use crate::common::AdventOfCodeDay;

pub struct Day23 {
    input: Vec<u8>,
}

impl Day23 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/23_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        let cups = input_str
                        .chars()
                        .map(|p| p.to_string().parse::<u8>().unwrap())
                        .collect::<Vec<u8>>();

        Self {
            input: cups
        }
    }
}

impl Day23 {
    fn do_move(cups: &mut Vec<u8>) {

        verboseln!("Cups: {:?}", cups);

        let n1 = cups[1];
        let n2 = cups[2];
        let n3 = cups[3];

        verboseln!("pick up: {}, {}, {}", n1,n2,n3);

        let mut dest = (cups[0] + 9-1-1) % 9 + 1;
        while !cups.iter().skip(4).any(|p| *p == dest) {
            dest = (dest + 9-1-1) % 9 + 1;
        }
        let dest_idx = cups.iter().position(|p| *p==dest).unwrap() + 1;

        verboseln!("destination: {}, (idx: {})", dest,dest_idx);

        cups.insert(dest_idx, n3);
        cups.insert(dest_idx, n2);
        cups.insert(dest_idx, n1);

        cups.remove(1);
        cups.remove(1);
        cups.remove(1);
        
        let f = cups.remove(0);
        cups.push(f);

        verboseln!();
    }

    fn do_move_linkedlist(cups: &mut [u32; 1_000_000], currcup: u32) -> u32 {
        let n0 = currcup;
        let n1 = cups[n0 as usize];
        let n2 = cups[n1 as usize];
        let n3 = cups[n2 as usize];
        let n4 = cups[n3 as usize];

        let mut dest = (n0+(1_000_000-1)) % 1_000_000;
        while dest == n1 || dest == n2 || dest == n3 {
            dest = (dest+(1_000_000-1)) % 1_000_000;
        }

        let d1 = cups[dest as usize];

        //verboseln!("Cups [ptr]: {:?}", cups.iter().take(16).collect::<Vec<_>>());
        //verboseln!("current: {}", currcup);
        //verboseln!("picked: {},{},{}", n1,n2,n3);
        //verboseln!("destination: {}", dest);

        // remove after curr
        cups[n0 as usize]   = n4;

        // insert after dest
        cups[dest as usize] = n1;
        cups[n3 as usize]   = d1;

        return n4;
    }
}

impl AdventOfCodeDay for Day23 {

    fn task_1(&self) -> String {

        let mut cups = self.input.clone();

        for _ in 0..100 {
            Self::do_move(&mut cups);
        }

        let c1idx = cups.iter().position(|p| *p==1).unwrap();
        
        let mut r = String::new();
        for idx in 1..9 {
            r = r + &cups[(idx+c1idx) % 9].to_string();
        }

        return r;
    }

    
    fn task_2(&self) -> String  {
        let mut cups = [0u32; 1_000_000]; // at cell[x] is the value of the cup right to the cup with the value x  (-> single-linked-list)

        for idx in 0..1_000_000 {
            if idx == (1_000_000-1) {
                cups[idx] = (self.input[0]-1) as u32;
            } else if idx > 8 {
                cups[idx] = (idx+1) as u32;
            } else if idx == 8 {
                cups[(self.input[idx]-1) as usize] = 9;
            } else {
                cups[(self.input[idx]-1) as usize] = (self.input[idx+1 as usize]-1) as u32;
            }
        }

        let mut curr = (self.input[0]-1) as u32;
        for _ in 0..10_000_000 {
            curr = Self::do_move_linkedlist(&mut cups, curr);
        }

        let n1 = cups[0 as usize]  as u128;
        let n2 = cups[n1 as usize] as u128;

        verboseln!("{} * {}", n1+1, n2+1);

        return ((n1+1)*(n2+1)).to_string();
    }
    
}
