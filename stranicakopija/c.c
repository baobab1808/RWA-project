#include <stdio.h>
#include <string.h>

typedef struct{
    char ime[10];
    char prezime[16];
} osoba;

int main(){

    osoba studenti[] = {{"Davor", "Horvat"},
                        {"Danijela", "Kovac"},
                        {"David", "Babic"},
                        {"Ema", "Kovac"}};

    printf("%d ", strncmp(studenti[0].ime, studenti[1].ime, 2));
    printf("%d ", strncmp(studenti[0].ime, studenti[3].ime, 3));
    strcpy(studenti[3].prezime, studenti[2].prezime);
    printf("%d ", strcmp(studenti[1].prezime, studenti[3].prezime));
    strncpy(studenti[3].ime, studenti[0].ime, 4);
    printf("%d ", strncmp(studenti[0].ime, studenti[3].ime, 3));

    return 0;
}