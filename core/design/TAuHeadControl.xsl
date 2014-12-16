<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="TAuHeadControl">
        
        <title><xsl:value-of select="option/siteTitle"/></title>
        <meta name="author" content="{option/author}"/>
        
        <xsl:for-each select="css/item">
            <link rel="stylesheet" type="text/css" href="{//siteurl}/{.}"/>
        </xsl:for-each>
        
        <xsl:for-each select="js/item">
            <script type="text/javascript" src="{//siteurl}/{.}"/>
        </xsl:for-each>
        
        <xsl:for-each select="meta/item">
            <meta name="{name}" content="{content}"/>
        </xsl:for-each>
        <meta name="generator" content="AllUnit is all you need" />
        <meta charset="UTF-8"/>
        <script type="text/javascript">var siteurl = '<xsl:value-of select="//siteurl"/>/';</script>
    </xsl:template>
</xsl:stylesheet>
