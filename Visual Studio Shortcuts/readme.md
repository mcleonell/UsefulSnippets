# How to install
In visual studio go to `Tools > Code Snippets Manager` and click on `Import`.

Now you can use the `propraise` shortcut to produces the following code snippet

```c#
private string privateProp;

public string PublicProp
{
    get { return privateProp; }
    set
    {
        privateProp = value;
        RaisePropertyChanged(nameof(PublicProp));
    }
}
```