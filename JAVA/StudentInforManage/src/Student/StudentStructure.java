package Student;

public class StudentStructure {
    private String uuid;
    private String sno;
    private String name;
    private String sex;
    private String major;
    private int grade;
    private String school;
    private int age;

    /*
    Initialize StudentStructure
     */
    public void setUuid(String uuid) {
        this.uuid = uuid;
    }

    public void setSno(String sno) {
        this.sno = sno;
    }

    public void setName(String name) {
        this.name = name;
    }

    public void setSex(String sex) {
        this.sex = sex;
    }

    public void setMajor(String major) {
        this.major = major;
    }

    public void setGrade(int grade) {
        this.grade = grade;
    }

    public void setSchool(String school) { this.school = school; }

    public void setAge(int age) { this.age = age; }

    /*
    Create external access method
     */

    public String getUuid() {
        return uuid;
    }

    public String getSno() {
        return sno;
    }

    public String getName() {
        return name;
    }

    public String getSex() {
        return sex;
    }

    public String getMajor() {
        return major;
    }

    public int getGrade() {
        return grade;
    }

    public String getSchool() { return school; }

    public int getAge() {return age; }
}
