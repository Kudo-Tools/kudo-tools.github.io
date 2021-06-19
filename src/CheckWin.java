public class CheckWin {
    public String getWinner(Box[][] boxes) {
        String[][] layout = new String[3][3];
        for(int x = 0; x < 3; x++) {
            for(int y = 0; y < 3; y++) {
                layout[x][y] = (boxes[x][y].getSelected()) ? boxes[x][y].getOccupation() : null;
            }
        }

        for(int x = 0; x < 3; x++) {
            if(layout[x][0] != null &&  layout[x][0] == layout[x][1] && layout[x][1] == layout[x][2]) {
                return layout[x][0];
            }
        }
        for(int y = 0; y < 3; y++) {
            if(layout[0][y] != null && layout[0][y] == layout[1][y] && layout[1][y] == layout[2][y]) {
                return layout[0][y];
            }
        }
        if(layout[0][0] != null) {
            if(layout[0][0] == layout[1][1] && layout[1][1] == layout[2][2]) {
                return layout[0][0];
            } else if (layout[2][0] == layout[1][1] && layout[1][1] == layout[0][2]) {
                return layout[1][1];
            }
        }
        return null;
    }
}
