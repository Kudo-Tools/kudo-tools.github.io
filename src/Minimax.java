public class Minimax {

    private Box[][] createTempBoard(Box[][] template) {
        Box[][] tempBoxes = new Box[3][3];
        for(int x = 0; x < 3; x++) {
            for(int y = 0; y < 3; y++) {
                tempBoxes[x][y] = new Box(x, y);
                String occuptation = template[x][y].getOccupation();
                if(occuptation == null) {
                    continue;
                } else if(occuptation.equals("Computer")) {
                    tempBoxes[x][y].setBackendSelected(true);
                    tempBoxes[x][y].setComputer();
                } else if(occuptation.equals("Human")) {
                    tempBoxes[x][y].setBackendSelected(template[x][y].getSelected());
                    tempBoxes[x][y].setHuman();
                }
            }
        }
        return tempBoxes;
    }

    public int[] bestChoice(Board board) {
        Box[][] boxes = board.getBoxes();
        
        String scores[][] = new String[3][3];
        for(int x = 0; x < 3; x++) {
            for(int y = 0; y < 3; y++) {
                if(!boxes[x][y].getSelected()) {
                    int[] set = detectChoice(boxes, 0, 0, x, y, true);
                    int beta = set[0];
                    int alpha = set[1];
                    scores[x][y] = Integer.toString(alpha - beta);
                } else {
                    scores[x][y] = null;
                }
            }
        }

        
        long best = 0;
        int xPos = 0;
        int yPos = 0;

        for(int x = 0; x < 3; x++) {
            for(int y = 0; y < 3; y++) {
                if(!boxes[x][y].getSelected()) {
                    best = Integer.parseInt(scores[x][y]);
                    xPos = x;
                    yPos = y;
                    break;
                }
            }
        }

        for(int x = 0; x < 3; x++) {
            for(int y = 0; y < 3; y++) {
                if(scores[x][y] != null && Integer.parseInt(scores[x][y]) > best) {
                    best = Integer.parseInt(scores[x][y]);
                    xPos = x;
                    yPos = y;
                }
            }
        }
        System.out.println("Times ran = " + possibilities);
        return new int[] {xPos, yPos};
    }

    int possibilities = 0;

    public int[] detectChoice(Box[][] box, int beta, int alpha, int xPos, int yPos, boolean computer) {
        possibilities++;
        if(xPos >= 3 || yPos >= 3) {
            return new int[] {beta,alpha};
        }
        
        Box[][] tempBoxes = createTempBoard(box);
        tempBoxes[xPos][yPos].setBackendSelected(true);
        if(computer) {
            tempBoxes[xPos][yPos].setComputer();
        } else {
            tempBoxes[xPos][yPos].setHuman();
        }

        String winner = new CheckWin().getWinner(tempBoxes);
        if(winner != null) {
            if(winner.equals("Computer"))
                alpha++;
            else
                beta++;
        }

        int[] values = new int[] {beta,alpha};
        for(int x = 0; x < 3; x++) {
            for(int y = 0; y < 3; y++) {
                if(!tempBoxes[x][y].getSelected()) {
                    int[] temp = detectChoice(tempBoxes, beta, alpha, x, y, !computer);
                    values[0] += temp[0];
                    values[1] += temp[1];
                }
            }
        }
        return values;
    }
}
