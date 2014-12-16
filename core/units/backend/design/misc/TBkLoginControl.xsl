<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="TBkLoginControl">
        <div class="form login-form">
            <form method="post">
                Login
                <input type="text" name="{name/login}"/>
                Password
                <input type="password" name="{name/password}"/>
                <input type="submit" name="onBkLogin" value="Login"/>
            </form>
        </div>
    </xsl:template>
</xsl:stylesheet>
