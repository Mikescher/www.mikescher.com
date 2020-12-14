use crate::common::AdventOfCodeDay;

pub struct Day03 {
    width: i32,
    height: i32,
    input: Vec<Vec<bool>>,
}

impl Day03 {
    pub fn new() -> Self {
        let input_bytes = include_bytes!("../res/03_input.txt");
        let input_str = String::from_utf8_lossy(input_bytes);
        
        let lines = input_str.lines().map(String::from).collect::<Vec<String>>();

        Self {
            width: lines[0].len() as i32,
            height: lines.len() as i32,

            input: lines.iter().map(|l| l.chars().map(|c| c=='#').collect()).collect(),
        }
    }

    pub fn get(&self, x: i32, y: i32) -> bool {
        if y >= self.height { return false }
        return self.input[y as usize][(x % self.width) as usize]
    }

    pub fn treecount(&self, dx: i32, dy: i32) -> i32 {
        (0..self.height).filter(|y| self.get(dx*y, dy*y)).count() as i32
    }
}

impl AdventOfCodeDay for Day03 {

    fn task_1(&self) -> String {
        return self.treecount(3, 1).to_string()
    }

    fn task_2(&self) -> String  {
        verboseln!("[1,1]: {}", self.treecount(1, 1));
        verboseln!("[3,1]: {}", self.treecount(3, 1));
        verboseln!("[5,1]: {}", self.treecount(5, 1));
        verboseln!("[7,1]: {}", self.treecount(7, 1));
        verboseln!("[1,2]: {}", self.treecount(1, 2));

        let prod = self.treecount(1, 1) *
                   self.treecount(3, 1) *
                   self.treecount(5, 1) *
                   self.treecount(7, 1) *
                   self.treecount(1, 2);

        return prod.to_string();
    }
}